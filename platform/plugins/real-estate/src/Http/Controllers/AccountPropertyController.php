<?php

namespace Botble\RealEstate\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\RealEstate\Forms\AccountPropertyForm;
use Botble\RealEstate\Http\Requests\AccountPropertyRequest;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\RealEstate\Services\SaveFacilitiesService;
use Botble\RealEstate\Tables\AccountPropertyTable;
use EmailHandler;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealEstateHelper;
use SeoHelper;
use Illuminate\Support\Facades\DB;
use Auth;





class AccountPropertyController extends Controller
{
    /**
     * @var AccountInterface
     */
    protected $accountRepository;

    /**
     * @var PropertyInterface
     */
    protected $propertyRepository;

    /**
     * @var AccountActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param AccountInterface $accountRepository
     * @param PropertyInterface $propertyRepository
     * @param AccountActivityLogInterface $accountActivityLogRepository
     */
    public function __construct(
        Repository $config,
        AccountInterface $accountRepository,
        PropertyInterface $propertyRepository,
        AccountActivityLogInterface $accountActivityLogRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->propertyRepository = $propertyRepository;
        $this->activityLogRepository = $accountActivityLogRepository;

        Assets::setConfig($config->get('plugins.real-estate.assets'));
    }

    /**
     * @param Request $request
     * @param AccountPropertyTable $propertyTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Response
     * @throws \Throwable
     */
    public function index(AccountPropertyTable $propertyTable)
    {
         SeoHelper::setTitle(__('Properties'));

         return $propertyTable->render('plugins/real-estate::account.table.base');
    }

    /**
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function create(Request $request, FormBuilder $formBuilder)
    {

            //   if (!auth('account')->user()->canPost()) {
            //       abort(403);
            //   }

              SeoHelper::setTitle(__('Write a property'));
        //    $points = DB::table('points')->select('property_add_value')->first();
        //    foreach($points as $key=>$value){

        //    }
        //    $author_id = Auth('account')->id();
        //    $fetch = DB::table('re_properties')->select('id')->where('author_id',$author_id)->get();
        //       return $fetch;
        //    $results = DB::table('re_properties')->select('name','location','content')->where('id',$fetch)->get();
        //    return $results;
            //  if(isset($fetch)){
                // $count = DB::table('re_properties')->select('id')->where('author_id',$author_id)->count();
                // return $count;
        //        $add = DB::table('re_accounts')->where('id',$author_id)->update([
        //            'points'=>$value
        //        ]);
        //          echo "data added successfully";
            
            // }else {
                //   echo "points not credited";
            // }
              return $formBuilder->create(AccountPropertyForm::class)->renderForm();
           
           
            //   $points = DB::table('points')->select('property_add_value')->first();
            //   foreach($points as $key=>$value){
                // echo $value;
            //  }
            // return $points;
            //    $author_id = Auth('account')->id();
            //  return $author_id;
            // $pluck = DB::table('re_accounts')->select('id')->get();
            // return $pluck;
            //   $fetch = DB::table('re_properties')->select('id','location')->where('author_id',$author_id)->get();
            //   if(!empty($fetch)){
            //      $add = DB::table('re_accounts')->where('id',$author_id)->update([
            //          'points'=>$value
            //      ]);
            //      echo "data added successfully";
            //  }else {
            //       return "points not credited";
            //   }

    }

    /**
     * @param AccountPropertyRequest $request
     * @param BaseHttpResponse $response
     * @param AccountInterface $accountRepository
     * @param SaveFacilitiesService $saveFacilitiesService
     * @return BaseHttpResponse
     */
    public function store(
        AccountPropertyRequest $request,
        BaseHttpResponse $response,
        AccountInterface $accountRepository,
        SaveFacilitiesService $saveFacilitiesService
    ) {
        
        
        // if (!auth('account')->user()->canPost()) {
        //     abort(403);
        // }

        $request->merge(['expire_date' => now()->addDays(RealEstateHelper::propertyExpiredDays())]);

        /**
         * @var Property $property
         */
         
         
        $property = $this->propertyRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => auth('account')->id(),
            'author_type' => Account::class,
        ]));
        
        
        
        $sqlLastInsertId = DB::table('re_properties')->orderBy('id' , 'DESC')->first();
        if ($property) {
            $property->features()->sync($request->input('features', []));
            
            $sqlUpdatePro = DB::table('re_properties')->where('id' , $sqlLastInsertId->id)->update([
                "personal_details" => $request->Personal_Details
            ]);

            $saveFacilitiesService->execute($property, $request->input('facilities', []));
        }

        event(new CreatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'create_property',
            'reference_name' => $property->name,
            'reference_url'  => route('public.account.properties.edit', $property->id),
        ]);


        $sqlCre = DB::table('re_accounts')->where('id' , auth('account')->id())->first();
        if($sqlCre->credits !='' && $sqlCre->credits > 1){
            $account = $accountRepository->findOrFail(auth('account')->id());
            $account->credits--;
            $account->save();
        }else{
            $account = $accountRepository->findOrFail(auth('account')->id());
            $account->credits = 0;
            $account->save();
        }
       
        $points = DB::table('points')->select('property_add_value')->first();
         foreach($points as $key=>$value){
            
         }
         
         $author_id = Auth('account')->id();
         $fetch = DB::table('re_properties')->select('id')->where('author_id',$author_id)->get();
	     if(isset($fetch)){
             $count = DB::table('re_properties')->select('id')->where('author_id',$author_id)->count();
               
               $previous_points = DB::table('re_accounts')->select('points')->where('id',$author_id)->first();
                    foreach($previous_points as $lock=>$v_points){
             
                    }
               
               $add = DB::table('re_accounts')->where('id',$author_id)->update([
                   'points'=>$v_points+$value
               ]);
                //  echo "data added successfully";
            
          } else {
                //  echo "points not credited";
            }

        EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'post_name'   => $property->name,
                'post_url'    => route('property.edit', $property->id),
                'post_author' => $property->author->name,
            ])
            ->sendUsingTemplate('new-pending-property');

        return $response
            ->setPreviousUrl(route('public.account.properties.index'))
            ->setNextUrl(route('public.account.properties.edit', $property->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     *
     * @throws \Throwable
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth('account')->id(),
            'author_type' => Account::class,
        ]);

        if (!$property) {
            abort(404);
        }

        event(new BeforeEditContentEvent($request, $property));

        SeoHelper::setTitle(trans('plugins/real-estate::property.edit') . ' "' . $property->name . '"');

        return $formBuilder
            ->create(AccountPropertyForm::class, ['model' => $property])
            ->renderForm();
    }

    /**
     * @param int $id
     * @param AccountPropertyRequest $request
     * @param BaseHttpResponse $response
     * @param SaveFacilitiesService $saveFacilitiesService
     * @return BaseHttpResponse
     *
     */
    public function update(
        $id,
        AccountPropertyRequest $request,
        BaseHttpResponse $response,
        SaveFacilitiesService $saveFacilitiesService
    ) {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth('account')->id(),
            'author_type' => Account::class,
        ]);

        if (!$property) {
            abort(404);
        }

        $property->fill($request->except(['expire_date']));

        $this->propertyRepository->createOrUpdate($property);

        $property->features()->sync($request->input('features', []));

        $saveFacilitiesService->execute($property, $request->input('facilities', []));

        event(new UpdatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'update_property',
            'reference_name' => $property->name,
            'reference_url'  => route('public.account.properties.edit', $property->id),
        ]);

        return $response
            ->setPreviousUrl(route('public.account.properties.index'))
            ->setNextUrl(route('public.account.properties.edit', $property->id))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function destroy($id, BaseHttpResponse $response)
    {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth('account')->id(),
            'author_type' => Account::class,
        ]);

        if (!$property) {
            abort(404);
        }

        $this->propertyRepository->delete($property);

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'delete_property',
            'reference_name' => $property->name,
        ]);

        return $response->setMessage(__('Delete property successfully!'));
    }

    /**
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function renew($id, BaseHttpResponse $response)
    {
        $job = $this->propertyRepository->findOrFail($id);

        $account = auth('account')->user();

        if ($account->credits < 1) {
            return $response->setError(true)->setMessage(__('You don\'t have enough credit to renew this property!'));
        }

        $job->expire_date = $job->expire_date->addDays(RealEstateHelper::propertyExpiredDays());
        $job->save();

        $account->credits--;
        $account->save();

        return $response->setMessage(__('Renew property successfully'));
    }
}
