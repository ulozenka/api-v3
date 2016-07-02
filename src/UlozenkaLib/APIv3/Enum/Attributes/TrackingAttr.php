<?php

namespace UlozenkaLib\APIv3\Enum\Attributes;

/**
 * Class BranchAttr
 * @package UlozenkaLib\APIv3\Enum
 */
class TrackingAttr
{

    /** Response Attributes */
    const RESPONSE_CONSIGNMENT = 'consignment';
    const RESPONSE_TRANSPORT_SERVICE = 'transport_service';
    const RESPONSE_STATUSES = 'statuses';

    /** Consignment Attributes */
    const CONSIGNMENT_LINKS = '_links';
    const CONSIGNMENT_ID = 'id';
    const CONSIGNMENT_PARTNER_CONSIGNMENT_ID = 'partner_consignment_id';
    const CONSIGNMENT_CASH_ON_DELIVERY = 'cash_on_delivery';
    const CONSIGNMENT_CURRENCY = 'currency';
    const CONSIGNMENT_PARCEL_COUNT = 'parcel_count';
    const CONSIGNMENT_CARD_PAYMENT_ALLOWED = 'card_payment_allowed';

    /** TransportService Base Attributes */
    const TS_LINKS = '_links';
    const TS_ID = 'id';
    const TS_NAME = 'name';
    const TS_DESTINATION_BRANCH = 'destination_branch';

    /** TransportService DestinationBranch Attributes */
    const TS_DESTINATION_BRANCH_LINKS = '_links';
    const TS_DESTINATION_BRANCH_ID = 'id';
    const TS_DESTINATION_BRANCH_NAME = 'name';
    const TS_DESTINATION_BRANCH_STREET = 'street';
    const TS_DESTINATION_BRANCH_TOWN = 'town';
    const TS_DESTINATION_BRANCH_ZIP = 'zip';
    const TS_DESTINATION_BRANCH_COUNTRY = 'country';
    const TS_DESTINATION_BRANCH_GPS = 'gps';
    const TS_DESTINATION_BRANCH_GPS_LATITUDE = 'lat';
    const TS_DESTINATION_BRANCH_GPS_LONGITUDE = 'lng';
    const TS_DESTINATION_BRANCH_ANNOUNCEMENT = 'announcement';

    /** Status Attributes */
    const STATUS_LINKS = '_links';
    const STATUS_ID = 'id';
    const STATUS_NAME = 'name';
    const STATUS_TRACKING_NAME = 'tracking_name';
    const STATUS_DATE = 'date';

    /** Query String Parameters */
    const QS_IDENTIFIER = 'identifier';
    const QS_LANG = 'lang';
}
