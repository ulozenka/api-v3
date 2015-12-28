<?php

namespace UlozenkaLib\APIv3\Tests\Formatter;

use DateTime;
use Tester\Assert;
use Tester\TestCase;
use UlozenkaLib\APIv3\Enum\Attributes\LabelAttr;
use UlozenkaLib\APIv3\Formatter\JsonFormatter;
use UlozenkaLib\APIv3\Model\ConnectorResponse;
use UlozenkaLib\APIv3\Resource\Labels\Request\LabelRequest;

require __DIR__ . '/../bootstrap.php';

/**
 * TEST: JsonFormatterTest
 *
 * @author Petr Vácha <petr.vacha@ulozenka.cz>
 * @author Jaroslav Líbal <mail@jaroslavlibal.cz>
 */
class JsonFormatterTest extends TestCase
{

    /** @var JsonFormatter */
    private $jsonFormatter;

    public function __construct()
    {
        $this->jsonFormatter = new JsonFormatter();
    }

    public function testFormatGetLabelsRequest()
    {
        $consignments = [444000, 1422231, "1123654"];
        $request = new LabelRequest($consignments, LabelAttr::TYPE_PDF, 1, 1);
        $jsonStringRequest = $this->jsonFormatter->formatGetLabelsRequest($request);
        $expectedJsonString = file_get_contents(__DIR__ . '/data/getLabelsRequest.json');
        Assert::same($expectedJsonString, $jsonStringRequest);
    }

    public function testFormatGetLabelsResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function () use ($connectorResponse) {
            $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatGetLabelsResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/getLabelsErrorResponse.json');
        $connectorResponse = new ConnectorResponse(401, $json, []);
        $getLabelsResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $code = $getLabelsResponse->getResponseCode();
        $data = $getLabelsResponse->getData();
        $errors = $getLabelsResponse->getErrors();

        Assert::same(401, $code);
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(1001, $errors[0]->getCode());
        Assert::same('X-Shop header missing. You have to send your shop id in the X-Shop http header of your request.', $errors[0]->getDescription());
    }

    public function testFormatGetLabelsResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/getLabelsResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $getLabelsResponse = $this->jsonFormatter->formatGetLabelsResponse($connectorResponse);
        $code = $getLabelsResponse->getResponseCode();
        $errors = $getLabelsResponse->getErrors();
        $link = $getLabelsResponse->getLinks()[0];

        $labels = $getLabelsResponse->getData();
        $directLabelsString = $getLabelsResponse->getLabelsString();
        $firstLabelString = $labels[0]->getLabelString();

        Assert::same(200, $code);
        Assert::same([], $errors);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://partner.ulozenka.cz/v3/labels', $link->getUrl());
        Assert::count(1, $labels);
        Assert::type('\UlozenkaLib\APIv3\Model\Label\Label', $labels[0]);
        Assert::same($directLabelsString, $firstLabelString);
        Assert::same("^XA^FO125,020^A0,20,20^FDVeskera na pohled nerozpoznatelna poskozeni musi byt pisemne^FS^FO150,040^A0,20,20^FDnahlasena do DPD behem 2 dnu po doruceni zasilky.^FS^FO125,060^A0,20,20^FDNotification on damage which is not recognisable from the outside^FS^FO150,080^A0,20,20^FDhas to be submitted to DPD within 2 days in writting.^FS^FO000,100^GB831,0,6^FS^FO770,0108^A0R,20,20^FDDPD Direct Parcel Distribution SK s, Depot 650^FS^FO750,0108^A0R,20,20^FDTechnicka 7^FS^FO730,0108^A0R,20,20^FDSK-82104 Bratislava^FS^FO710,0108^A0R,20,20^FDTelefon: +421 2 4445 1419^FS^FO710,364^XGDPDV,1,1^FS^FO552,100^GB0,392,4^FS^FO688,100^GB0,392,4^FS^FO000,372^GB552,0,6^FS^FO336,372^GB0,120,4^FS^FO000,492^GB831,0,6^FS^FO528,0108^A0R,20,20^FDAdresa doruceni^FS    ^FO020,0120^A0,30,30^FDZvolen, Tehelna 4 (KLEMO spol. s r.^FS    ^FO020,0155^A0,30,30^FDDPD Parcel Shop^FS       ^FO020,0190^A0,30,30^FD18373^FS^FO020,0225^A0,30,30^FDTehelna 4^FS^FO020,0260^A0,30,30^FDZvolen^FS^FO020,0320^A0,50,50^FDSK - 96001^FS^FO664,0108^A0R,20,20^FDOdesilatel^FS^FO646,0108^A0R,18,18^FDUlozenka s.r.o.^FS^FO628,0108^A0R,18,18^FDNovohradska 736/36^FS^FO610,0108^A0R,18,18^FDCZ-37001 Ceske Budejovice^FS^FO592,0108^A0R,18,18^FDTelefon: +420777208204^FS^FO574,0108^A0R,18,18^FDE-mail: info@ulozenka.cz^FS^FO020,0385^A0,20,20^FDCislo objednavky:^FS^FO020,0410^A0,25,25^FD26^FS^FO348,0388^A0,20,20^FDPocet baliku (ks):^FS^FO348,0410^A0,30,30^FD1 / 1^FS^FO348,0442^A0,20,20^FDHmotnost (kg):^FS^FO348,0464^A0,30,30^FD0,10^FS^FO000,0642^GB831,0,6^FS^FO000,0882^GB831,0,8^FS^FO450,500^BY3,2,100^BC,,N,,,A^FD1572160^FS^FO540,610^A0,30,30^FD1572160^FS^FO020,0500^A0,20,20^FDOd: Ulozenka - test^FS^FS^FO020,0550^A0,20,20^FDZpusob platby: HOTOVOST^FS^FO020,0575^A0,20,20^FDPodatelna/vraceni: cb / pha1^FS^FO020,0615^A0,30,30^FDPARCEL SHOP^FS^FO020,0714^A0,20,20^FDTrack^FS05^FO020,0654^A0,70,70^FD0650^FS^FO164,0676^A0,40,40^FD5011^FS^FO260,0676^A0,40,40^FD8835^FS^FO354,0676^A0,40,40^FD05^FS^FO400,0683^A0,30,30^FDG^FS^FO450,0658^FB350,,,R^A0,40,40^FDD-B2C-PSD^FS^FO730,0702^A0,20,20^FDService^FS^FO070,0724^FB740,,,C^A0,120,100^FDSK-0651^FS^FO530,0822^FB256,,,R^A0,76,76^FD120^FS^FO180,0830^FB450,,,C^A0,30,30^FD337 - SK - 96001^FS^FO180,0860^FB450,,,C^A0,20,20^FD27.12.2015 13:12-20150907-ulozenka^FS^FO080,910^BY3,,224^BC,,N,,,A^FD%009600106505011883505337703^FS^FO105,1140^A0,40,40^FD0096 001 0650 5011 8835 05 337 703 5^FS^XZCT~~CD,~CC^~CT~^XA~TA000~JSN^LT0^MNW^MTD^PON^PMN^LH0,0^JMA^PR4,4~SD15^JUS^LRN^CI0^XZ~DG000.GRF,15360,060,,:::::::iY010gH010H01,,iY0170gG0740,iY02A80g0HA0,iX01DHDY01DHDC,iX02AHA80W02AIA,iW01775740W0K740,iW02AJAX0LA0,iV015DKDU015DJDF0,iV02ALAV0MA8,iV0N740S017M7,iV0OAT02AMA,iU05DLDFD0R015DND0,iU0QAR0QA8,iT0R7R057P7,iT02AOA80Q02APA,iQ0101DDFDHDFDHDF0K010K017DIDFDHDFDC1,iS0RAT02APA0,iR017P740S017P74,iR02APAN080L0RA,iQ01DQDM07D0L05FDOD,iR0QA80L0HF80L0QA80,iP017P740L07FFE0L017P74,iP02APAN0IFE0M0RA,iO01DQDM01FIFC0K015DNDFD,iP0QA80L0KFE0M0QA80,iO0R7M01FKFC0L0Q750,iO0QA80L03FKFE0M0QA8,iN01DDFDMDM01FMFM01DNDFDC,iN0RAM03FMF80L02APA,iM017N75740L07FNFM017P740,iM0QA80L03EFNFC0L02APA0,iL01DFDHDFDJDC0K017FPFM01FDFDHDFDHDFD,iL0RAM01FQF80L02APA,iK017P740L07FRFM017M757740iK02APAN0TF80L02APA0iJ01FDPDM01FSFC0L01DPD0N0N8Q0P8N0N8R0QA80L07FKFEFLFE0M0QA8M01FNFD0M01FOFD0K01FNFD0N01757N7M01FLFC1FLFC0L0Q74N0QF80L0PFHEK01FOFE80M0PAN0LFHEH03FLF80L0PA8M01FQFL01FQFC0I01FQFM01DLDFDD0L03FLFC001FLFC0J0105DNDCN0RF80J01FQFE0I01FQF80L0OA80L03FLFJ0MFE0M0OA8M01FRFK01FRFC0H01FQFC0K017M750L01FLFC0I07FLF40L0O74N0SF80J0SFC0H01FQFE0L0NA80L03FLFL0MFE0L02AMA8M01FRFC10H01FRFC0H01FRFC0J01DMDM01FMFL07FLFM01DMDCN0SFC0I01FRFE0H01FRFC0K0NAM03FLFC0K03FLFC0L02ALA8N0TFJ01FSFI01FSFK017L740L07FLFN0MFE0L017L74N0TFK0TF8001FSFL0MAN0MFE0M03FKFE0M0MA8M01FSFC0H01FSFC001FSFC0I01DHDFDD0K0H17FLF10N07FLFM01DHDFDDCN0TFE0H01FSFC001FSFC0J0LAM01FLFE0O03FLF80L02AJA8M01FTFI01FSFE001FSFC0I017J740L07FLFC0O01FLFE0L017J74N0UFJ0JFKAKFE001FSFE0J0KA80L0MFE0Q03FKFE0M0KA8M01FIFIDNF8001FIFC0H017FJFH01FIFIDNFJ01DJDC0K01FLFC0Q01FLFC0K01DJDCN0JFC0H03FKF8001FIF80I03FIFE001FIF80H0MFK0KA80K0BFKFE0S03FKFE0L0KA8N0JFC0I07FJFC001FIFC0I01FJFH01FIFJ01FKF80H017J740J01FLFE0S03FLFC0J017J74N0JFC0I02FJFC0H0JF80J0JFE001FIF80I03EFIF80I0KA80J03FLF80T0MFE0K0KA8M01FIFC0I01FJFC001FIFC0J07FIFH01FIF80I01FJFC0H01DJDC0I017FLFV07FLFK01DJDCN0JFC0J03FIFE001FIF80J03FIF801FIF80J07FIFE0I0KA80I03FKFE0W0MFE0J0KA8M01FIFC0J01FIFE001FIFC0J03FIFH01FIFL07FIFE0H017J740H01FLFC0W03FLFC0H017J74N0JFC0K0JFE0H0JF80J03FIF801FIF80J03FIFE0I0KA80H03FLF80W01FLFE0I0KA8M01FIFC0K07FIFH01FIFC0J01FIFH01FIF80J01FJFI01DJDC0H07FLFg07FKFE0H01DJDCN0JFC0K07FIFH01FIF80J03FIF801FIF80K0JFE0I0KA80H03FKF80Y03FKFE0I0KA8N0JFC0K07FIFH01FIFC0J01FIFH01FIFM07FIFI017J740H07FKFgH07FJFE0H017J74N0JFC0K02FIFI0JF80J02FIFH01FIF80K07FIFJ0KA80H03FJFE0gG03FJFE0I0KA8M01FIFC0K07FIFH01FIFC0J01FIFH01FIF80K07FIFI01DHDFDC0H07FJFC0010X01FKFI01DDFDDCN0JFC0K03FIF801FIF80J03FIF801FIF80K03FIF80H0KA80H03FJFC0gG03FJFE0I0KA8M01FIFC0K01FIF801FIFC0J07FIFH01FIFM01FIF80017J740H07FKFC0Y01FKFE0H017J74N0JFC0K01FIF800FIF80J0JFE001FIF80K01FIF80H0KA80H03FKFE0Y03FKFE0I0KA8M01FIFC0K01FIFC01FIFC0I01FJFH01FIF80K01FIF8001DJDC0H07FLFC0W01FLFE0H01DJDCN0JFC0K01FIF801FIF80I03FIFE001FIF80K01FIF80H0KA80H03FLFC0W03FLFE0I0KA8N0JFC0K01FIFC01FIFC0I07FIFE001FIFM01FIFC0017J740H07FMFX07FLFE0H017J74N0JFC0L0JF800FIFA2I2FEFHFE001FIF80L0JF80H0KA80H03FMF80V0EFLFE0I0KA8M01FIFC0K01FIFC01FSFC001FIF80K01FIFC001DJDC0H07FNF010S07FNFI01DJDCN0JFC0K01FIF801FSFC001FIF80L0JF80H0KA80H03FNF80T0OFE0I0KA8M01FIFC0K01FIFC01FSFC001FIFM01FIFC0017J740H07FNFC0S03FNFE0H017J74N0JFC0L0JF800FSFI01FIF80L0JF80H0KA80H03FOF80R0PFE0I0KA8M01FIFC0K01FIFC01FSFI01FIF80K01FIF8001DJDC0H07FOFD0Q07FOFE0H01DJDCN0JFC0K01FIF801FRFE0H01FIF80K01FIF80H0KA80H03FPF80P0QFE0I0KA8N0JFC0K01FIFC01FRFC0H01FIFM01FIF80017J740H07FHFDFLFC0O01FLFDFHFE0H017J74N0JFC0L0JF800FRF80H01FIF80K01FIF80H0KA80H03FHFCFLFE0O07FKFE1FHFE0I0KA8M01FIFC0K01FIF801FRF80H01FIF80J0H1JF8001DHDFDC0H07FHFC7FLF10J01011FLFD1FIFI01DDFDDCN0JFC0K03FIF801FQFE0I01FIF80K03FIF80H0KA80H03FHFC0FLFC0M03FLF81FHFE0I0KA8M01FIFC0K07FIFH01FQFC0I01FIFM07FIFI017J740H07FHFC07FLFN07FLF01FHFE0H017J74N0JFC0K03FIFI0PFE80J01FIF80K07FIFJ0KA80H03FHFC00FLFE0K03FLF801FHFE0I0KA8M01FIFC0K07FIFH01FOF50K01FIF80K07FIFI01DJDC0H07FHFC007FLFK017FKFD001FHFE0H01DJDCN0JFC0K07FHFE001FIF80Q01FIF80K0JFE0I0KA80H03FHFC0H0MF80I03FLF8001FHFE0I0KA8N0JFC0K07FIFH01FIFC0Q01FIFL01FJFI017J740H07FHFC0H07FLFJ07FLFI01FHFE0H017J74N0JFC0K0JFE0H0JF80Q01FIF80J02FIFE0I0KA80H03FHFC0H03FKFE80H0KFEFC0H01FHFE0I0KA8M01FIFC0J01FJFH01FIFC0Q01FIF80J07FIFE0H01DJDC0H07FHFC0H01FMFH07FLFD0H01FIFI01DJDCN0JFC0J03FIFE001FIF80Q01FIF80J07FIFC0I0KA80H03FHFC0I03FLFH0MFE0I01FHFE0I0KA8M01FIFC0J07FIFC001FIFC0Q01FIFL07FIFC0H017J740H07FHFC0I01FLFC1FLFC0I01FHFE0H017J74N0JFC0I01FJFC0H0JF80Q01FIF80I03FJF80I0KA80H03FHFC0J07FKFE3FKFE0J01FHFE0I0KA8M01FIFC0H01FKFC001FIFC0Q01FIF80015FKFJ01DJDC0H07FHFC0J01FSFC0J01FHFE0H01DJDCN0JFC80AFLF8001FIF80Q01FIF808AFLFK0KA80H03FHFC0K03FQFE0K01FHFE0I0KA8N0UFI01FIFC0Q01FTFJ017J740H07FHFC0K01FQFC0K01FHFE0H017J74N0UFJ0JF80Q01FSFE0J0KA80H03FHFC0L0QFE0L01FHFE0I0KA8M01FTFI01FIFC0Q01FSFC0I01DHDFDC0H07FHFC0L07FOFD0L01FIFI01DDFDDCN0TFE0H01FIF80Q01FSFC0J0KA80H03FHFC0L01FOF80L01FHFE0I0KA8M01FSFC0H01FIFC0Q01FSFC0I017J740H07FHFC0M07FNFN01FHFE0H017J74N0TF80I0JF80Q01FSF80J0KA80H03FHFC0M03FMFC0M01FHFE0I0KA8M01FSFJ01FIFC0Q01FSFK01DJDC0H07FHFC0M01FMFO01FHFE0H01DJDCN0SFC0I01FIF80Q01FRF80K0KA80H03FHFC0O0LF80N01FHFE0I0KA8N0SFC0I01FIFC0Q01FRFL017J740H07FHFC0O07FJFP01FHFE0H017J74N0SFL0JF80Q01FQFE0L0KA80H03FHFC0O02FIFE0O01FHFE0I0KA8M01FQFC0J01FIFC0Q01FQFD0K01DJDC0H07FHFC0O01FIF80O01FIFI01DJDCN0RF80J01FIF80Q01FQF80L0KA80H03FHFC0P0JFQ01FHFE0I0KA8M01FPFC0K01FIFC0Q01FPFC0L017J740H07FHFC0P07FHFQ01FHFE0H017J74N0PFE80L0JF80Q01FOFE0N0KA80H03FHFC0P07FFE0P01FHFE0I0KA8M01FOFD0L01FIFC0Q01FOF80M01DJDC0H07FHFC0P07FHFQ01FHFE0H01DHDFDCN0NFE80M01FIF80Q01FMFA80O0KA80H03FHFC0P07FFE0P01FHFE0I0KA8iK0H5I740H07FHFC0P07FHFQ01FHFE0H017I750iL0JA80H03FHFC0P07FFE0P01FHFE0I0JA80gQ010gH010L0101DDFDC0H07FHFC0P07FHFQ01FIFI01DDFD,iL02AHA80H03FHFC0P0JFQ01FHFE0I0JA,iL017H740H07FHFC0P07FHFQ01FHFE0H017H74,iM02AA80H03FHFC0P07FFE0P01FHFE0I0IA0,iM01DDC0H07FHFC0P07FHFQ01FHFE0H01DHD0,iN0HA80H03FHFC0P07FFE0P01FHFE0I0HA80,iN01740H07FHFC0P07FHFQ01FHFE0H0174,iO0280H03FHFC0P07FFE0P01FHFE0I0A0,iO01C0H07FHFC0O017FHFQ01FIFI01C0,iP080H03FHFC0P0JFQ01FHFE0I080,iP040H07FHFC0P07FHFQ01FHFE0H01,iT03FHFC0P07FFE0P01FHFE,iT07FHFC0P07FHFQ01FHFE,iT03FHFC0P07FFE0P01FHFE,iT07FHFC0P07FHFQ01FHFE,iT03FHFC0P07FFE0P01FHFE,iQ01007FHFC0P07FHFQ01FIF,iT03FHFC0P0JFQ01FHFE,iT07FHFC0P07FHFQ01FHFE,iT03FHFC0P07FFE0P01FHFE,iT07FHFC0P07FHFQ01FHFE,iT03FHFE0P07FFE0P03FHFE,iT07FIFQ07FHFQ07FHFE,iT03FFEF80O07FFE0O03FIFE,iT07FJFC0M017FHFM0101FKF,iT03FJFC0N0JFO03FJFE,iT07FKFO07FHFO07FJFE,iT03FKF80M07FFE0M02FKFE,iT07FLFN07FHFN07FKFE,iT03FLF80L07FFE0M0MFE,iT01FLFC0L07FHFM03FLFC,iU03FKFE0L07FFE0L03FEFIFE0,iU01FLFC0K07FHFL01FLFC0,iV07FLF80J0JFL0MFE,iV01FLFC0J07FHFK03FLFC,iW07FKFE0J07FFE0J03FKFE0,iW01FLFC0I07FHFJ01FLFD0,iX0MFE0I07FFE0I03FLF80,iX07FLFJ07FHFJ0MFE,iX03FLFC0H07FFE0H03FLF8,iX01FMFH017FHFI07FLF0,j0MFE00FIFH03FLF80,j07FLFH07FHFH07FKFE,j03FLF807FFE01FLFE,j01FMF07FHF07FLF8,jG03FLF87FFE0FLFE0,jG01FLFC7FHF1FLFC0,jH07FKFEFHFE7FIFEFE,iU010K03FWFC,jI0XF8,jI01FUFC0,jJ07FSFE,iV050L01FSFC0L01,iV020M0TF80L02,iV0740L07FRFM016,iV02A0L02FNFEFF80L02A,iV07DC0K01FQFM01DD,iV02A80L03FOFE0M0HA,iV0I7M01FOF80L0H76,iV02AHAM03FMFC0L02AHA,iV05DDF0L01FMFM01DID,iV02AHA80L03FKFE0M0JA,iV0J760L01FKFC0L0J76,iV02AIAN0EFEFFE0M0KA,iV07DJDK0107FIFD10K05DFDFD,iV02AJA80L0JF80L0LA,iV0L740L07FHFM017J76,iV02AKAN0HF80L02AKA,iV05DKDC0L07D0L01DLD,iV02ALAN080L0NA,iV0N740S017L76,iV02AMAT02AMA,iV05DMDS015FDJDFD,iV02AMA80R0OA,iV0P7R0O76,iV02ANA80P0PA,iV05DODP05DNDF,iV02AOA80N0QA,iV057N7H5N057O76,iV02APA80L0RA,iV01DHDFDHDFDIDL05DIDFDHDFDD4,iW02APAL02APA0,iW01F7O740I017P740,iX02APAJ02APA,iX01DPDI01DPDC,iY02APAH02APA0,iY0157M7H5417N75740,j02APA2APA,j01DPD5DPD,jG0gHA8,jG0g7570,jH0gA80,jG015DXD,jH02AXA,jI0W750,jI02AUA80,jI01FDHDFDHDFDHDFDFD,jJ02ATA,jJ017Q7574,jK0TA0,jK05DRD0,jL0RA80,jL057P7,jM0PA8,jM05DND0,jN0NA80,jN0N7,jN02AKA8,jN01FDHDFD8,jO02AJA0,jO017I740,jP02AHA,jP01DF8,jQ02A0,jQ0140,,::::::::::::::::::::~DG001.GRF,121600,100,,::::::::::H01FoUFC:::::::::::::::::::::::H01FJFE0oI03FJFC::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::H01FoUFC:::::::::::::::::::::::,:::::::::::::::::::::^XA^MMT^PW815^LL1199^LS0^FT288,288^XG000.GRF,1,1^FS^FT0,1216^XG001.GRF,1,1^FS^FT63,298^A0,70,70^FDDPD PARCEL SHOP^FS^CI0^FT63,370^A0,35,35^FDVyzvednuti prijemcem^FS^CI0^FT63,440^A0,25,25^FDAdresa doruceni:^FS^CI0^FT79,492^A0,30,30^FDZvolen, Tehelna 4 (KLEMO spol. s r. o. )^FS^CI0^FT79,538^A0,30,30^FDDPD Parcel Shop^FS^CI0^FT79,580^A0,30,30^FDTehelna 4^FS^CI0^FT79,644^A0,40,40^FDSK-96001 Zvolen^FS^CI0^FT69,726^A0,25,25^FDPrijemce:^FS^CI0    ^FT76,800^A0,40,40^FDMartin Venus^FS^CI0    ^FT76,950^A0,40,40^FD+420777341522^FS^CI0^FT71,1010^A0,25,25^FDCislo objednavky a ID zasilky:^FS^CI0^FT80,1124^A0,30,30^FDD-B2C-PSD-06505011883505-20151227^FS^CI0^FT80,1072^A0,30,30^FD06505011883505^FS^CI0^FO64,1027^GB674,123,4^FS^FO66,742^GB674,220,4^FS^FO63,458^GB675,219,4^FS^PQ1,0,1,Y^XZ^XA^ID000.GRF^FS^XZ^XA^ID001.GRF^FS^XZ", $directLabelsString);
    }

    public function testFormatGetStatusHistoryResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function () use ($connectorResponse) {
            $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatGetStatusHistoryResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/getStatusHistoryErrorResponse.json');
        $connectorResponse = new ConnectorResponse(401, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $code = $getStatusHistoryResponse->getResponseCode();
        $data = $getStatusHistoryResponse->getData();
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same(401, $code);
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(1001, $errors[0]->getCode());
        Assert::same('X-Shop header missing. You have to send your shop id in the X-Shop http header of your request.', $errors[0]->getDescription());
    }

    public function testFormatGetStatusHistoryResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/getStatusHistoryResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $consignmentStatuses = $getStatusHistoryResponse->getData();
        $consignmentStatus = $consignmentStatuses[5];
        $consignment = $consignmentStatus->getConsignment();
        $status = $consignmentStatus->getStatus();
        $dateTime = $consignmentStatus->getDateTime();
        $conignmentLink = $consignment->getLinks()[0];
        $link = $getStatusHistoryResponse->getLinks()[0];
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same([], $errors);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.cz/v3/statushistory?timeFrom=20151123232058', $link->getUrl());
        Assert::count(7, $consignmentStatuses);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $conignmentLink);
        Assert::same('self', $conignmentLink->getResourceName());
        Assert::same('https://api.ulozenka.cz/v3/consignments/3255848', $conignmentLink->getUrl());
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\ConsignmentStatus', $consignmentStatus);
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\Consignment', $consignment);
        Assert::same(3255848, $consignment->getId());
        Assert::same('051580000012', $consignment->getPartnerConsignmentId());
        Assert::same('test_pns_1006', $consignment->getOrderNumber());
        Assert::type('\UlozenkaLib\APIv3\Model\StatusHistory\Status', $status);
        Assert::same(4, $status->getId());
        Assert::same('připraveno k výdeji', $status->getName());
        Assert::equal(new DateTime('2015-11-24 16:50:05 Europe/Prague'), $dateTime);
    }

    public function testFormatCreateConsignmentResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function () use ($connectorResponse) {
            $this->jsonFormatter->formatCreateConsignmentResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatCreateConsignmentResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/createConsignmentErrorResponse.json');
        $connectorResponse = new ConnectorResponse(400, $json, []);
        $getStatusHistoryResponse = $this->jsonFormatter->formatGetStatusHistoryResponse($connectorResponse);
        $code = $getStatusHistoryResponse->getResponseCode();
        $data = $getStatusHistoryResponse->getData();
        $errors = $getStatusHistoryResponse->getErrors();

        Assert::same(400, $code);
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(4002, $errors[0]->getCode());
        Assert::same('Given currency (CZ) not found.', $errors[0]->getDescription());
    }

    public function testFormatCreateConsignmentResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/createConsignmentResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $createConsignmentResponse = $this->jsonFormatter->formatCreateConsignmentResponse($connectorResponse);
        $data = $createConsignmentResponse->getData();
        $consignment = $createConsignmentResponse->getConsignment();
        $link = $createConsignmentResponse->getLinks()[0];
        $errors = $createConsignmentResponse->getErrors();

        Assert::same([], $errors);
        Assert::count(1, $data);
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/consignments/3049048', $link->getUrl());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Response\Consignment', $consignment);
        Assert::same(3049048, $consignment->getId());
        Assert::same(5158, $consignment->getShopId());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Receiver', $consignment->getReceiver());
        Assert::same('John', $consignment->getReceiver()->getName());
        Assert::same('Doe', $consignment->getReceiver()->getSurname());
        Assert::same(null, $consignment->getReceiver()->getCompany());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Address', $consignment->getReceiver()->getAddress());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getStreet());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getTown());
        Assert::same(null, $consignment->getReceiver()->getAddress()->getZip());
        Assert::same('CZE', $consignment->getDestinationCountry());
        Assert::same('+420602602602', $consignment->getReceiver()->getPhone());
        Assert::same('foo@ulozenka.cz', $consignment->getReceiver()->getEmail());
        Assert::same('123123', $consignment->getOrderNumber());
        Assert::same(null, $consignment->getPartnerConsignmentId());
        Assert::same(null, $consignment->getVariable());
        Assert::same(2, $consignment->getParcelCount());
        Assert::same(200, $consignment->getCashOnDelivery());
        Assert::same(null, $consignment->getInsurance());
        Assert::same(null, $consignment->getStatedPrice());
        Assert::same('CZK', $consignment->getCurrency());
        Assert::same(14, $consignment->getRegisterBranchId());
        Assert::same(1, $consignment->getDestinationBranchId());
        Assert::equal(new DateTime('2015-11-29 12:59:20 Europe/Prague'), $consignment->getTimeCreated());
        Assert::equal(new DateTime('2015-11-29 12:59:20 Europe/Prague'), $consignment->getTimeReceived());
        Assert::same(null, $consignment->getMaxStoringDate());
        Assert::same(null, $consignment->getTimeClosed());
        Assert::type('\UlozenkaLib\APIv3\Model\Consignment\Status', $consignment->getStatus());
        Assert::same(1, $consignment->getStatus()->getId());
        Assert::same('čekáme na doručení', $consignment->getStatus()->getName());
        Assert::same(null, $consignment->getParcelNumber());
        Assert::same(3.21, $consignment->getWeight());
        Assert::same(false, $consignment->getRequireFullAge());
        Assert::same(true, $consignment->getAllowCardPayment());
        Assert::same(false, $consignment->getPaidByCard());
        Assert::same(null, $consignment->getNote());
        Assert::equal(new DateTime('2015-11-29 12:59:21 Europe/Prague'), $consignment->getTimeUpdated());
        Assert::same(null, $consignment->getTimeCodSent());
        Assert::same(null, $consignment->getTimeInvoiceSent());
        Assert::same(1, $consignment->getTransportServiceId());
        Assert::same(false, $consignment->getMaxStoringDateIncreasedByClient());
        Assert::same(false, $consignment->getMaxStoringDateIncreasedByPartner());
    }

    public function testFormatGetTransportServiceBranchesResponseThrowsException()
    {
        $connectorResponse = new ConnectorResponse(200, 'Hello world!', []);
        Assert::exception(function () use ($connectorResponse) {
            $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        }, '\Exception', 'Ulozenka API did not respond with valid JSON.');
    }

    public function testFormatGetTransportServiceBranchesResponseError()
    {
        $json = file_get_contents(__DIR__ . '/data/getTransportServiceBranchesErrorResponse.json');
        $connectorResponse = new ConnectorResponse(404, $json, []);
        $getTransportServiceBranchesResponse = $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        $code = $getTransportServiceBranchesResponse->getResponseCode();
        $link = $getTransportServiceBranchesResponse->getLinks()[0];
        $data = $getTransportServiceBranchesResponse->getData();
        $errors = $getTransportServiceBranchesResponse->getErrors();

        Assert::same(404, $code);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/transportservices/44/branches', $link->getUrl());
        Assert::same([], $data);
        Assert::count(1, $errors);
        Assert::same(5003, $errors[0]->getCode());
        Assert::same('Requested transport service not found', $errors[0]->getDescription());
    }

    public function testFormatGetTransportServiceBranchesResponse()
    {
        $json = file_get_contents(__DIR__ . '/data/getTransportServiceBranchesResponse.json');
        $connectorResponse = new ConnectorResponse(200, $json, []);
        $getTransportServiceBranchesResponse = $this->jsonFormatter->formatGetTransportServiceBranchesResponse($connectorResponse);
        $code = $getTransportServiceBranchesResponse->getResponseCode();
        $link = $getTransportServiceBranchesResponse->getLinks()[0];
        $errors = $getTransportServiceBranchesResponse->getErrors();
        $registerBranches = $getTransportServiceBranchesResponse->getRegisterBranches();
        $secondRegisterBranch = $registerBranches[1];
        $destinationBranches = $getTransportServiceBranchesResponse->getDestinationBranches();

        // response code
        Assert::same(200, $code);

        // links
        Assert::type('\UlozenkaLib\APIv3\Model\Link', $link);
        Assert::same('self', $link->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/transportservices/1/branches?shopId=5158&destinationOnly=0&registerOnly=0&includeInactive=1', $link->getUrl());

        // errors
        Assert::same([], $errors);

        // register branches
        Assert::count(2, $registerBranches);
        Assert::type('\UlozenkaLib\APIv3\Model\TransportService\Branch\RegisterBranch', $secondRegisterBranch);
        $branchLinks = $secondRegisterBranch->getLinks();
        Assert::count(3, $branchLinks);
        $websiteLink = $branchLinks[0];
        $pictureLink = $branchLinks[1];
        $selfLink = $branchLinks[2];
        Assert::same('website', $websiteLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/pobocky/3/ostrava-28-rijna-1422-299', $websiteLink->getUrl());
        Assert::same('picture', $pictureLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/cdn/images/branches/register/3.png', $pictureLink->getUrl());
        Assert::same('self', $selfLink->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/branches/3', $selfLink->getUrl());
        Assert::same(3, $secondRegisterBranch->getId());
        Assert::same('ostra', $secondRegisterBranch->getShortcut());
        Assert::same('Ostrava, 28.října 1422/299', $secondRegisterBranch->getName());
        $destinations = $secondRegisterBranch->getDestinations();
        Assert::count(2, $destinations);
        $destination = $destinations[1];
        Assert::same('SVK', $destination->getCountry());
        Assert::same(true, $destination->getActive());
        Assert::same(false, $destination->getPreparing());
        Assert::same(true, $destination->getAllowedConsignmentTypes()->getStandardConsignment());
        Assert::same(false, $destination->getAllowedConsignmentTypes()->getBackwardConsignment());
        Assert::same('+420777208204', $secondRegisterBranch->getPhone());
        Assert::same('info@ulozenka.cz', $secondRegisterBranch->getEmail());
        Assert::same('28.října', $secondRegisterBranch->getStreet());
        Assert::same('1422/299', $secondRegisterBranch->getHouseNumber());
        Assert::same('Ostrava - Mariánské Hory a Hulváky', $secondRegisterBranch->getTown());
        Assert::same('70900', $secondRegisterBranch->getZip());
        $district = $secondRegisterBranch->getDistrict();
        Assert::same(14, $district->getId());
        Assert::same('CZ080', $district->getNutsNumber());
        Assert::same('Moravskoslezský kraj', $district->getName());
        Assert::same('CZE', $secondRegisterBranch->getCountry());
        $openingHours = $secondRegisterBranch->getOpeningHours();
        $regularOpeningHours = $openingHours->getRegular();
        $monday = $regularOpeningHours->getMonday();
        Assert::count(2, $monday);
        Assert::same('11:00', $monday[0]->getOpen());
        Assert::same('12:00', $monday[0]->getClose());
        Assert::same('13:00', $monday[1]->getOpen());
        Assert::same('19:00', $monday[1]->getClose());
        $tuesday = $regularOpeningHours->getTuesday();
        Assert::count(1, $tuesday);
        Assert::same('11:00', $tuesday[0]->getOpen());
        Assert::same('19:00', $tuesday[0]->getClose());
        $saturday = $regularOpeningHours->getSaturday();
        Assert::same([], $saturday);
        $exceptionOpeningHours = $openingHours->getExceptions();
        Assert::same([], $exceptionOpeningHours);
        $gps = $secondRegisterBranch->getGps();
        Assert::same(49.82552, $gps->getLatitude());
        Assert::same(18.242718, $gps->getLongitude());
        $navigation = $secondRegisterBranch->getNavigation();
        Assert::same('general navigation', $navigation->getGeneral());
        Assert::same('car navigation', $navigation->getCar());
        Assert::same('public transport navigation', $navigation->getPublicTransport());
        Assert::same('other info', $secondRegisterBranch->getOtherInfo());
        Assert::same(true, $secondRegisterBranch->getCardPaymentAccepted());
        Assert::same(false, $secondRegisterBranch->getPartner());

        // destination branches
        Assert::count(4, $destinationBranches);
        $firstDestinationBranch = $destinationBranches[0];
        Assert::type('\UlozenkaLib\APIv3\Model\TransportService\Branch\DestinationBranch', $firstDestinationBranch);
        $branchLinks = $firstDestinationBranch->getLinks();
        Assert::count(3, $branchLinks);
        $websiteLink = $branchLinks[0];
        $pictureLink = $branchLinks[1];
        $selfLink = $branchLinks[2];
        Assert::same('website', $websiteLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/pobocky/6/brno-cernopolni-54-245', $websiteLink->getUrl());
        Assert::same('picture', $pictureLink->getResourceName());
        Assert::same('https://www.ulozenka.cz/cdn/images/branches/destination/6.png', $pictureLink->getUrl());
        Assert::same('self', $selfLink->getResourceName());
        Assert::same('https://api.ulozenka.local/v3/branches/6', $selfLink->getUrl());
        Assert::same(6, $firstDestinationBranch->getId());
        Assert::same('brno2', $firstDestinationBranch->getShortcut());
        Assert::same('Brno, Černopolní 54/245', $firstDestinationBranch->getName());
        Assert::same(true, $firstDestinationBranch->getAllowedConsignmentTypes()->getStandardConsignment());
        Assert::same(true, $firstDestinationBranch->getAllowedConsignmentTypes()->getBackwardConsignment());
        Assert::same('+420777208204', $firstDestinationBranch->getPhone());
        Assert::same('info@ulozenka.cz', $firstDestinationBranch->getEmail());
        Assert::same('Černopolní', $firstDestinationBranch->getStreet());
        Assert::same('54/245', $firstDestinationBranch->getHouseNumber());
        Assert::same('Brno - Černá Pole', $firstDestinationBranch->getTown());
        Assert::same('61300', $firstDestinationBranch->getZip());
        $district = $firstDestinationBranch->getDistrict();
        Assert::same(11, $district->getId());
        Assert::same('CZ064', $district->getNutsNumber());
        Assert::same('Jihomoravský kraj', $district->getName());
        Assert::same('CZE', $firstDestinationBranch->getCountry());
        $openingHours = $firstDestinationBranch->getOpeningHours();
        $regularOpeningHours = $openingHours->getRegular();
        $monday = $regularOpeningHours->getMonday();
        Assert::count(1, $monday);
        Assert::same('11:00', $monday[0]->getOpen());
        Assert::same('19:00', $monday[0]->getClose());
        $tuesday = $regularOpeningHours->getTuesday();
        Assert::count(1, $tuesday);
        Assert::same('11:00', $tuesday[0]->getOpen());
        Assert::same('19:00', $tuesday[0]->getClose());
        $saturday = $regularOpeningHours->getSaturday();
        Assert::same([], $saturday);
        $exceptionOpeningHours = $openingHours->getExceptions();
        Assert::same([], $exceptionOpeningHours);
        $gps = $firstDestinationBranch->getGps();
        Assert::same(49.208607, $gps->getLatitude());
        Assert::same(16.614868, $gps->getLongitude());
        $navigation = $firstDestinationBranch->getNavigation();
        Assert::same('general navigation', $navigation->getGeneral());
        Assert::same('car navigation', $navigation->getCar());
        Assert::same('public transport navigation', $navigation->getPublicTransport());
        Assert::same('other info', $firstDestinationBranch->getOtherInfo());
        Assert::same(true, $firstDestinationBranch->getCardPaymentAccepted());
        Assert::same(false, $firstDestinationBranch->getPartner());
        $announcements = $firstDestinationBranch->getAnnouncements();
        Assert::count(2, $announcements);
        Assert::same('Změna otevírací doby', $announcements[0]->getTitle());
        Assert::same('V pátek bude otevřeno až do půlnoci', $announcements[0]->getText());
        Assert::same(12, $announcements[0]->getPriority());
        Assert::same('Havárie vody', $announcements[1]->getTitle());
        Assert::same('Z důvodu havárie vody bude pobočka uzavřena', $announcements[1]->getText());
        Assert::same(4, $announcements[1]->getPriority());

        Assert::same(false, $destinationBranches[3]->getActive());
        Assert::same('SVK', $destinationBranches[2]->getCountry());
        Assert::same(false, $destinationBranches[2]->getCardPaymentAccepted());
        Assert::same([], $destinationBranches[2]->getAnnouncements());
        Assert::same(true, $destinationBranches[1]->getPreparing());
    }

    public function testFormatCreateConsignmentRequest()
    {
        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu 21/3a', 'Praha', '14000');
        $receiver = new \UlozenkaLib\APIv3\Model\Consignment\Receiver();
        $receiver->setName('Jan')
            ->setSurname('Nový')
            ->setCompany('Společnost s.r.o.')
            ->setEmail('jan@novy.cz')
            ->setPhone('+420777208204')
            ->setAddress($address);
        $request = new \UlozenkaLib\APIv3\Resource\Consignments\Request\ConsignmentRequest($receiver, 'order_001', 2, 11);
        $request->setCashOnDelivery(12.3)
            ->setCurrency('CZK')
            ->setInsurance(500)
            ->setStatedPrice(200)
            ->setNote('Neklopit')
            ->setAllowCardPayment(true)
            ->setRequireFullAge(true)
            ->setDestinationCountry('CZE')
            ->setDestinationBranchId(50001)
            ->setRegisterBranchId(7)
            ->setWeight(21.3)
            ->setVariable(123321)
            ->setPartnerConsignmentId('051580000001');
        $request->requireLabel(\UlozenkaLib\APIv3\Enum\Attributes\LabelAttr::TYPE_PDF, 2, 4, true);
        $parcel1 = new \UlozenkaLib\APIv3\Model\Consignment\Parcel('10001');
        $parcel2 = new \UlozenkaLib\APIv3\Model\Consignment\Parcel('10002');
        $request->setParcels([$parcel1, $parcel2]);

        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        $expectedJsonString = file_get_contents(__DIR__ . '/data/createConsignmentRequest.json');
        Assert::same($expectedJsonString, $jsonStringRequest);

        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu', 'Praha', '14000', '21/3a');
        $receiver->setAddress($address);
        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        Assert::same($expectedJsonString, $jsonStringRequest);

        $address = new \UlozenkaLib\APIv3\Model\Consignment\Address('U průhonu', 'Praha', '14000', '21', '3a');
        $receiver->setAddress($address);
        $jsonStringRequest = $this->jsonFormatter->formatCreateConsignmentRequest($request);
        Assert::same($expectedJsonString, $jsonStringRequest);
    }
}

$test = new JsonFormatterTest();
$test->run();
