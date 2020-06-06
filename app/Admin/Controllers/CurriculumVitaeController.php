<?php

namespace App\Admin\Controllers;

use App\CurriculumVitae;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;
use Encore\Admin\Admin;
use Illuminate\Support\Str;

use App\Admin\Actions\Documents;
use App\Admin\Actions\Experiences;
use App\Admin\Actions\Certificates;
use App\Admin\Actions\Skills;

class CurriculumVitaeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Curriculum Vitae';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurriculumVitae());

        $grid->id('ID')->sortable();
        $grid->photo('Photo')->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('name', 'Name')->display(function () {
            $linknya = "curriculum-vitae/";
            return '<a href='.$linknya.$this->id.'>'.strtoupper($this->name).'</a>';
        })->sortable();
        $grid->rank('Rank')->sortable();
        $grid->column('Birth Date')->display(function () {
            return $this->place_of_birth.', '.$this->date_of_birth;
        });
        $grid->ppe_size('PPE');
        $grid->nationality('Nationality');
        $grid->email('Email');
        $grid->column('Phone / Mobile')->display(function () {
            return $this->home_tel.' '.$this->mobile_tel;
        });

        $grid->home_address('Address');

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', 'Name');
            $filter->like('rank', 'Rank');
            $filter->like('email', 'Email');
            $filter->like('home_tel', 'Phone');
            $filter->like('mobile_tel', 'Mobile');
            $filter->like('home_address', 'Address');
        });

        $grid->export(function ($export) {
            $export->filename('Data');
            $export->except(['photo']);
            $export->only(['id', 'name', 'rank', 'Birth Date', 'ppe_size',  'nationality', 'email', 'Phone / Mobile', 'home_address']);
            $export->originalValue(['name', 'place_of_birth', 'date_of_birth', 'home_tel', 'mobile_tel']);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CurriculumVitae::findOrFail($id));

        $show->photo()->image();
        $show->name()->as(function ($name) {
            return strtoupper("{$name}");
        });
        $show->rank('Rank')->badge();
        $show->ppe_size('PPE Size');
        $show->date_of_birth('Date of Birth');
        $show->place_of_birth('Place of Birth');
        $show->religion('Religion');
        $show->nationality('Nationality');
        $show->blood_group('Blood Group');
        $show->email('Email');
        $show->home_tel('Phone');
        $show->mobile_tel('Mobile');
        $show->home_address('Address');

        $show->TravelDocument('Travel Document', function ($TravelDocument) {
            $TravelDocument->resource('/admin/travel-document');
            $TravelDocument->document_type('Type');
            $TravelDocument->document_no('Number');
            $TravelDocument->document_date_of_issue('Issued Date');
            $TravelDocument->document_date_of_expiry('Expired Date');
            $TravelDocument->document_place_of_issue('Place of Issue');
            $TravelDocument->document_file('File Document')->lightbox(['width' => 50, 'height' => 50]);

            $TravelDocument->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('document_no','Document Number');
            });
            $TravelDocument->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
                $actions->disableEdit();
            });
            $TravelDocument->disableFilter();
            $TravelDocument->disableCreateButton();
            $TravelDocument->disableExport();
            $TravelDocument->disableColumnSelector();
            $TravelDocument->disableRowSelector();
            $TravelDocument->disableActions();
        });

        $show->Experiences('Experiences', function ($Experiences) {
            $Experiences->resource('/admin/experiences');
            $Experiences->name_of_vessel('Vessel Name');
            $Experiences->rank('Rank');
            $Experiences->vessel_type('Vessel Type');
            $Experiences->grt_hp('GRT / HP');
            $Experiences->company('Company')->upper();
            $Experiences->principle_name('Principle');
            $Experiences->column('Salary')->display(function () {
                return 'USD '.$this->salary;
            });
            $Experiences->column('Onboard Period')->display(function () {
                return $this->onboard_period_from.'<br>'.$this->onboard_period_to;
            });
            $Experiences->column('standby_status', 'Status')->label([
                'Stand By' => 'success',
                'Stand Out' => 'danger',
                'Candidate' => 'warning',
            ]);
            $Experiences->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
                $actions->disableEdit();
            });
            $Experiences->disableFilter();
            $Experiences->disableCreateButton();
            $Experiences->disableExport();
            $Experiences->disableColumnSelector();
            $Experiences->disableActions();
            $Experiences->disableRowSelector();
        });


        $show->Certificates('Certificates of Competency', function ($Certificates) {
            $Certificates->resource('/admin/certificates');
            
            $Certificates->ListCertificates()->certificate_of_competency_name('Certificate Name')->display (function ($certificate_of_competency_name) {
                return $certificate_of_competency_name;
            });

            $Certificates->capacity('Capacity');
            $Certificates->date_of_issue('Issued Date');
            $Certificates->date_of_expiry('Expired Date');
            $Certificates->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
                $actions->disableEdit();
            });
            $Certificates->disableFilter();
            $Certificates->disableCreateButton();
            $Certificates->disableExport();
            $Certificates->disableColumnSelector();
            $Certificates->disableActions();
            $Certificates->disableRowSelector();
        });


        $show->Skills('Skills Training Certificates', function ($Skills) {
            $Skills->resource('/admin/skills');

            $Skills->ListSkills()->skill_training_certificate_name('Certificate Name')->display (function ($skill_training_certificate_name) {
                return $skill_training_certificate_name;
            });

            $Skills->date_of_issue('Issued Date');
            $Skills->date_of_expiry('Expired Date');

            $Skills->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableView();
                $actions->disableEdit();
            });

            $Skills->disableFilter();
            $Skills->disableCreateButton();
            $Skills->disableExport();
            $Skills->disableColumnSelector();
            $Skills->disableActions();
            $Skills->disableRowSelector();
        });


        $show->panel()
            ->style('primary')
            ->title('Detail Data')
            ->tools(function ($tools) {
                $tools->disableDelete();
            });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {
        $form = new Form(new CurriculumVitae());

        $form->image('photo', 'Photo');
        $form->text('name', 'Name')->required();
        $form->text('rank', 'Rank')->required();
        $form->text('ppe_size', 'PPE Size')->required();
        $form->date('date_of_birth','Date of Birth')->placeholder('Select Date')->required();
        $form->text('place_of_birth', 'Place of Birth')->required()->icon('fa-map-marker');
        $nationality = [
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia And Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic Of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TP" => "East Timor",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island And Mcdonald Islands",
            "VA" => "Holy See (vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic Of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic Of",
            "KR" => "Korea, Republic Of",
            "KV" => "Kosovo",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            "MK" => "Macedonia, The Former Yugoslav Republic Of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States Of",
            "MD" => "Moldova, Republic Of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MS" => "Montserrat",
            "ME" => "Montenegro",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            "PM" => "Saint Pierre And Miquelon",
            "VC" => "Saint Vincent And The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia And The South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard And Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province Of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic Of",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis And Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];
        $form->select('nationality', 'Nationality')->options($nationality)->required();
        $form->select('religion', 'Religion')->options(['Islam' => 'Islam', 'Christianity' => 'Christianity', 'Hinduism' => 'Hinduism', 'Buddhism' => 'Buddhism', 'Other' => 'Other'])->required();
        $form->select('blood_group', 'Blood Group')->options(['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O', 'Unknown' => 'Unknown'])->required();
        $form->email('email', 'Email')->required();
        $form->text('home_tel', 'Home Phone')->required()->icon('fa-phone');
        $form->text('mobile_tel', 'Mobile Phone')->required()->icon('fa-mobile');
        $form->text('home_address', 'Address')->required()->icon('fa-home');

        // $form->hasMany('TravelDocument','Travel Document', function (Form\NestedForm $form) {
        //     $form->text('curriculum_vitae_id','ID');
        //     $form->display('curriculum_vitae_id','ID');
        //     $form->select('document_type', 'Type')->options(['Passport' => 'Passport', 'Seaman Book' => 'Seaman Book']);
        //     $form->text('document_no','Document No');
        //     $form->date('document_date_of_issue','Date of Issue');
        //     $form->date('document_date_of_expiry','Date of Expiry');
        //     $form->text('document_place_of_issue','Place of Issue');
        //     $form->image('document_file','Select File');
        // });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;

    }

}