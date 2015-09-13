<?php

namespace Client\MedicalBundle\Services\Company;

use Symfony\Component\HttpFoundation\Request;

class CompanySearch {

    private $request;
    private $em;
    private $locale;
    private $paginator;
    private $updateDiv;

    /**
     * @param Request $request
     * @param $locale
     */
    public function __construct(Request $request, $em, $locale, $paginator, $updateDiv)
    {
        $this->request = $request;
        $this->em = $em;
        $this->locale = $locale;
        $this->paginator = $paginator;
        $this->updateDiv = $updateDiv;
    }

    public function getAJAXParams() {
        return [
            'ssRatingPopular'=>$this->getRatingPopular(),
            'locale' => $this->locale,
            'ssPage' => $this->getPage(),
            'ssUpdateDiv'=>$this->updateDiv,
            'pagination' => $this->getPagination(),
            'snCategoryIds'=>$this->getCategoryIds(),
            'ssCityName'=>$this->getCityName(),
            'ssPerPage'=>$this->getPerPage()
        ];
    }

    public function getParams() {
        return [
            'ssPaymentOption'=>$this->getPaymentOption(),
            'ssClinicRating'=>$this->getClinicRating(),
            'ssCityName'=>$this->getCityName(),
            'ssLanguages'=>$this->getLanguages(),
            'ssRatingPopular'=>$this->getRatingPopular(),
            'locale' => $this->locale,
            'pagination' => $this->getPagination(),
            'ssPage' => $this->getPage(),
            'ssSerachParam' => $this->getSearchParam(),
            'ssUpdateDiv'=>$this->updateDiv,
            'snCategoryIds'=>$this->getCategoryIds(),
            'snNewsCategoryIds'=>$this->getCategoryIds(),
            'ssPerPage'=>$this->getPerPage(),
            'asMetaData'=>$this->getMetaData()
        ];
    }

    public function getBannerDetail() {
        $categoryIds = $this->getCategoryIds();
        $flag = $this->getFlag();
        $cityName = $this->getCityName();
        return $this->em->getRepository('AdminMedicalBundle:AdvertiseBanner')
            ->getAddBannerDetail('home_right', $categoryIds, $flag, $cityName, '', $this->locale);
    }

    private function getPagination() {
        $companyData = $this->getCompanyData();
        $page = $this->getPage();
        $perPage = $this->getPerPage();
        $pagination = $this->paginator->paginate($companyData, $page, $perPage);
        $pagination->setCustomParameters(['ssUpdateDiv' => $this->updateDiv,'ssPerPage' => $perPage]);
        return $pagination;
    }

    private function getLanguages() {
        $languages = $this->request->get('language');
        if(is_array($languages) && !empty($languages)) {
            $languages = implode(',',$languages);
        } else {
            $languages = $this->request->get('language');
        }

        return $languages;
    }

    private function getCategoryIds() {
        if($this->request->get('category_ids') != '') {
            $snCategoryIds = $this->request->get('category_ids');
        } else {
            $snCategoryIds = '';
        }

        return $snCategoryIds;
    }

    private function getPaymentOption() {
        $paymentOption = $this->request->get('paymentoption');
        if(is_array($paymentOption) && !empty($ssPaymentOption)) {
            $paymentOption = implode(',',$paymentOption);
        }

        return $paymentOption;
    }

    private function getRatingPopular() {
        return (($this->request->get('rate_popular') != '') ? $this->request->get('rate_popular') : 'best');
    }

    private function getPage() {
        return (($this->request->get('page') != '') ? $this->request->get('page') : 1);
    }

    private function getPerPage() {
        return (($this->request->get('per_page') != '') ? $this->request->get('per_page') : 10);
    }

    private function getClinicRating() {
        return $this->request->get('clinic_rate');
    }

    private function getCityName() {
        return $this->request->get('city_name');
    }

    private function getFlag() {
        return $this->request->get('ssFlag');
    }

    private function getSearchParam() {
        return $this->request->get('ssSearchParam');
    }

    private function getMetaData() {
        return $this->em->getRepository('AdminMedicalBundle:StaticArticles')
            ->getDetailByArticleType('WEBSITE_META_SETTINGS', $this->locale);
    }

    private function getMiddleBannerDetail() {
        $categoryIds = $this->getCategoryIds();
        $cityName = $this->getCityName();
        return $this->em->getRepository('AdminMedicalBundle:AdvertiseBanner')->
        getAddBannerDetail('company_center', $categoryIds, '' , $cityName, 'mid', $this->locale);
    }

    private function getCompanyData() {
        $searchParam = $this->getSearchParam();
        $cityName = $this->getCityName();
        $paymentOption = $this->getPaymentOption();
        $languages = $this->getLanguages();
        $perPage = $this->getPerPage();
        $middleBannerDetail = $this->getMiddleBannerDetail();

        $companyData = $this->em->getRepository('AdminMedicalBundle:Company')->
        getCompanyAllDetailForSearch_new($searchParam, $cityName, $paymentOption, $languages, $this->locale);
        foreach($companyData[0] as $key => $value) {
            $nameEditor = new NameEditor;
            $companyimage = $this->em->getRepository('AdminMedicalBundle:Company')->getCompanyImag($value['id']);
            $companyData[0][$key]['companyimag'] = $companyimage;
            $companyData[0][$key]['categoryName'] = $companyData[1][$key];
            $companyData[0][$key]['categoryNameRoute'] = $nameEditor->addDashBetweenWords($companyData[1][$key]);
            $companyData[0][$key]['categoryid'] = $companyData[3][$key];
            $companyData[0][$key]['city'] = $companyData[2][$key];
        }
        $count = ((count($companyData[0]) < 10) ? (count($companyData[0]) / 2) : ($perPage / 2));
        array_splice($companyData[0], $count, 0, $middleBannerDetail);

        return $companyData[0];
    }
}
