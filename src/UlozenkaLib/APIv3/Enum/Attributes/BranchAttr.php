<?php

namespace UlozenkaLib\APIv3\Enum\Attributes;

/**
 * Class BranchAttr
 * @package UlozenkaLib\APIv3\Enum
 */
class BranchAttr
{

    /** Response Attributes */
    const RESPONSE_REGISTER = 'register';
    const RESPONSE_DESTINATION = 'destination';

    /** Base Branch Attributes */
    const LINKS = '_links';
    const ID = 'id';
    const SHORTCUT = 'shortcut';
    const NAME = 'name';
    const STREET = 'street';
    const HOUSE_NUMBER = 'house_number';
    const TOWN = 'town';
    const ZIP = 'zip';
    const DISTRICT = 'district';
    const DISTRICT_ID = 'id';
    const DISTRICT_NUTS_NUMBER = 'nuts_number';
    const DISTRICT_NAME = 'name';
    const COUNTRY = 'country';
    const PARTNER = 'partner';

    /** Branch Attributes */
    const PHONE = 'phone';
    const EMAIL = 'email';
    const GPS = 'gps';
    const GPS_LATITUDE = 'latitude';
    const GPS_LONGITUDE = 'longitude';
    const NAVIGATION = 'navigation';
    const NAVIGATION_GENERAL = 'general';
    const NAVIGATION_CAR = 'car';
    const NAVIGATION_PUBLIC_TRANSPORT = 'public_transport';
    const OPENING_HOURS = 'opening_hours';
    const OPENING_HOURS_REGULAR = 'regular';
    const OPENING_HOURS_REGULAR_HOURS = 'hours';
    const OPENING_HOURS_REGULAR_HOURS_OPEN = 'open';
    const OPENING_HOURS_REGULAR_HOURS_CLOSE = 'close';
    const OPENING_HOURS_EXCEPTIONS = 'exceptions';
    const OTHER_INFO = 'orher_info';
    const CARD_PAYMENT = 'card_payment';

    /** Register Branch Attributes */
    const RB_DESTINATIONS = 'destinations';
    const RB_DESTINATIONS_COUNTRY = 'country';

    /** Destination Branch Attributes */
    const DB_ANNOUNCEMENTS = 'announcements';
    const DB_ANNOUNCEMENTS_TITLE = 'title';
    const DB_ANNOUNCEMENTS_TEXT = 'text';
    const DB_ANNOUNCEMENTS_PRIORITY = 'priority';

    /** Specific Attributes */
    const ALLOWED_CONSIGNMENT_TYPES = 'allowed_consignment_types';
    const ALLOWED_CONSIGNMENT_TYPES_STANDARD = 'standard_consignment';
    const ALLOWED_CONSIGNMENT_TYPES_BACKWARD = 'backward_consignment';
    const ACTIVE = 'active';
    const PREPARING = 'preparing';

    /** Query String Parameters */
    const QS_SHOP_ID = 'shopId';
    const QS_INCLUDE_INACTIVE = 'includeInactive';
    const QS_REGISTER_ONLY = 'registerOnly';
    const QS_DESTINATION_ONLY = 'destinationOnly';
    const QS_DESTINATION_COUNTRY = 'destinationCountry';
}
