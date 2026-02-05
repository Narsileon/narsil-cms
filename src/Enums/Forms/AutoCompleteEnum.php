<?php

namespace Narsil\Cms\Enums\Forms;

#region USE

use Narsil\Cms\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum AutoCompleteEnum: string
{
    use Enumerable;

    case ADDITIONAL_NAME = 'additional-name';
    case ADDRESS_LEVEL1 = 'address-level1';
    case ADDRESS_LEVEL2 = 'address-level2';
    case ADDRESS_LEVEL3 = 'address-level3';
    case ADDRESS_LEVEL4 = 'address-level4';
    case ADDRESS_LINE1 = 'address-line1';
    case ADDRESS_LINE2 = 'address-line2';
    case ADDRESS_LINE3 = 'address-line3';
    case BDAY = 'bday';
    case BDAY_DAY = 'bday-day';
    case BDAY_MONTH = 'bday-month';
    case BDAY_YEAR = 'bday-year';
    case CC_ADDITIONAL_NAME = 'cc-additional-name';
    case CC_CSC = 'cc-csc';
    case CC_EXP = 'cc-exp';
    case CC_EXP_MONTH = 'cc-exp-month';
    case CC_EXP_YEAR = 'cc-exp-year';
    case CC_FAMILY_NAME = 'cc-family-name';
    case CC_GIVEN_NAME = 'cc-given-name';
    case CC_NAME = 'cc-name';
    case CC_NUMBER = 'cc-number';
    case CC_TYPE = 'cc-type';
    case COUNTRY = 'country';
    case COUNTRY_NAME = 'country-name';
    case CURRENT_PASSWORD = 'current-password';
    case EMAIL = 'email';
    case FAMILY_NAME = 'family-name';
    case FAX = 'fax';
    case GIVEN_NAME = 'given-name';
    case HOME = 'home';
    case HONORIFIC_PREFIX = 'honorific-prefix';
    case HONORIFIC_SUFFIX = 'honorific-suffix';
    case IMPP = 'impp';
    case MOBILE = 'mobile';
    case NAME = 'name';
    case NEW_PASSWORD = 'new-password';
    case NICKNAME = 'nickname';
    case OFF = 'off';
    case ON = 'on';
    case ONE_TIME_CODE = 'one-time-code';
    case ORGANIZATION = 'organization';
    case ORGANIZATION_TITLE = 'organization-title';
    case PAGE = 'page';
    case PHOTO = 'photo';
    case POSTAL_CODE = 'postal-code';
    case SEX = 'sex';
    case STREET_ADDRESS = 'street-address';
    case TEL = 'tel';
    case TEL_AREA_CODE = 'tel-area-code';
    case TEL_COUNTRY_CODE = 'tel-country-code';
    case TEL_EXTENSION = 'tel-extension';
    case TEL_LOCAL = 'tel-local';
    case TEL_LOCAL_PREFIX = 'tel-local-prefix';
    case TEL_LOCAL_SUFFIX = 'tel-local-suffix';
    case TEL_NATIONAL = 'tel-national';
    case TRANSACTION_AMOUNT = 'transaction-amount';
    case TRANSACTION_CURRENCY = 'transaction-currency';
    case URL = 'url';
    case USERNAME = 'username';
    case WORK = 'work';
}
