<?php
/**
 * CreateObjectStorageResponseData
 *
 * PHP version 5
 *
 * @category Class
 * @package  Contabo\ContaboSdk
 * @author   Coderic Development Team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Contabo API
 *
 * # Introduction  Contabo API allows you to manage your resources using HTTP requests. This documentation includes a set of HTTP endpoints that are designed to RESTful principles. Each endpoint includes descriptions, request syntax, and examples.  Contabo provides also a CLI tool which enables you to manage your resources easily from the command line. [CLI Download and  Installation instructions.](https://github.com/contabo/cntb)  ## Product documentation  If you are looking for description about the products themselves and their usage in general or for specific purposes, please check the [Contabo Product Documentation](https://docs.contabo.com/).  ## Getting Started  In order to use the Contabo API you will need the following credentials which are available from the [Customer Control Panel](https://my.contabo.com/api/details): 1. ClientId 2. ClientSecret 3. API User (your email address to login to the [Customer Control Panel](https://my.contabo.com/api/details)) 4. API Password (this is a new password which you'll set or change in the [Customer Control Panel](https://my.contabo.com/api/details))  You can either use the API directly or by using the `cntb` CLI (Command Line Interface) tool.  ### Using the API directly  #### Via `curl` for Linux/Unix like systems  This requires `curl` and `jq` in your shell (e.g. `bash`, `zsh`). Please replace the first four placeholders with actual values.  ```sh CLIENT_ID=<ClientId from Customer Control Panel> CLIENT_SECRET=<ClientSecret from Customer Control Panel> API_USER=<API User from Customer Control Panel> API_PASSWORD='<API Password from Customer Control Panel>' ACCESS_TOKEN=$(curl -d \"client_id=$CLIENT_ID\" -d \"client_secret=$CLIENT_SECRET\" --data-urlencode \"username=$API_USER\" --data-urlencode \"password=$API_PASSWORD\" -d 'grant_type=password' 'https://auth.contabo.com/auth/realms/contabo/protocol/openid-connect/token' | jq -r '.access_token') # get list of your instances curl -X GET -H \"Authorization: Bearer $ACCESS_TOKEN\" -H \"x-request-id: 51A87ECD-754E-4104-9C54-D01AD0F83406\" \"https://api.contabo.com/v1/compute/instances\" | jq ```  #### Via `PowerShell` for Windows  Please open `PowerShell` and execute the following code after replacing the first four placeholders with actual values.  ```powershell $client_id='<ClientId from Customer Control Panel>' $client_secret='<ClientSecret from Customer Control Panel>' $api_user='<API User from Customer Control Panel>' $api_password='<API Password from Customer Control Panel>' $body = @{grant_type='password' client_id=$client_id client_secret=$client_secret username=$api_user password=$api_password} $response = Invoke-WebRequest -Uri 'https://auth.contabo.com/auth/realms/contabo/protocol/openid-connect/token' -Method 'POST' -Body $body $access_token = (ConvertFrom-Json $([String]::new($response.Content))).access_token # get list of your instances $headers = @{} $headers.Add(\"Authorization\",\"Bearer $access_token\") $headers.Add(\"x-request-id\",\"51A87ECD-754E-4104-9C54-D01AD0F83406\") Invoke-WebRequest -Uri 'https://api.contabo.com/v1/compute/instances' -Method 'GET' -Headers $headers ```  ### Using the Contabo API via the `cntb` CLI tool  1. Download `cntb` for your operating system (MacOS, Windows and Linux supported) [here](https://github.com/contabo/cntb) 2. Unzip the downloaded file 3. You might move the executable to any location on your disk. You may update your `PATH` environment variable for easier invocation. 4. Configure it once to use your credentials              ```sh    cntb config set-credentials --oauth2-clientid=<ClientId from Customer Control Panel> --oauth2-client-secret=<ClientSecret from Customer Control Panel> --oauth2-user=<API User from Customer Control Panel> --oauth2-password='<API Password from Customer Control Panel>'    ```  5. Use the CLI              ```sh    # get list of your instances    cntb get instances    # help    cntb help    ```  ## API Overview  ### [Compute Management](#tag/Instances)  The Compute Management API allows you to manage compute resources (e.g. creation, deletion, starting, stopping) of VPS and VDS (please note that Storage VPS are not supported via API or CLI) as well as managing snapshots and custom images. It also offers you to take advantage of [cloud-init](https://cloud-init.io/) at least on our default / standard images (for custom images you'll need to provide cloud-init support packages). The API offers provisioning of cloud-init scripts via the `user_data` field.  Custom images must be provided in `.qcow2` or `.iso` format. This gives you even more flexibility for setting up your environment.  ### [Object Storage](#tag/Object-Storages)  The Object Storage API allows you to order, upgrade, cancel and control the auto-scaling feature for [S3](https://en.wikipedia.org/wiki/Amazon_S3) compatible object storage. You may also get some usage statistics. You can only buy one object storage per location. In case you need more storage space in a location you can purchase more space or enable the auto-scaling feature to purchase automatically more storage space up to the specified monthly limit.  Please note that this is not the S3 compatible API. It is not documented here. The S3 compatible API needs to be used with the corresponding credentials, namely an `access_key` and `secret_key`. Those can be retrieved by invoking the User Management API. All purchased object storages in different locations share the same credentials. You are free to use S3 compatible tools like [`aws`](https://aws.amazon.com/cli/) cli or similar.  ### [Private Networking](#tag/Private-Networks)  The Private Networking API allows you to manage private networks / Virtual Private Clouds (VPC) for your Cloud VPS and VDS (please note that Storage VPS are not supported via API or CLI). Having a private network allows the associated instances to have a private and direct network connection. The traffic won't leave the data center and cannot be accessed by any other instance.  With this feature you can create multi layer systems, e.g. having a database server being only accessible from your application servers in one private network and keep the database replication in a second, separate network. This increases the speed as the traffic is NOT routed to the internet and also security as the traffic is within it's own secured VLAN.  Adding a Cloud VPS or VDS to a private network requires a reinstallation to make sure that all relevant parts for private networking are in place. When adding the same instance to another private network it will require a restart in order to make additional virtual network interface cards (NICs) available.  Please note that for each instance being part of one or several private networks a payed add-on is required. You can automatically purchase it via the Compute Management API.  ### [Secrets Management](#tag/Secrets)  You can optionally save your passwords or public ssh keys using the Secrets Management API. You are not required to use it there will be no functional disadvantages.  By using that API you can easily reuse you public ssh keys when setting up different servers without the need to look them up every time. It can also be used to allow Contabo Supporters to access your machine without sending the passwords via potentially unsecure emails.  ### [User Management](#tag/Users)  If you need to allow other persons or automation scripts to access specific API endpoints resp. resources the User Management API comes into play. With that API you are able to manage users having possibly restricted access. You are free to define those restrictions to fit your needs. So beside an arbitrary number of users you basically define any number of so called `roles`. Roles allows access and must be one of the following types:  * `apiPermission`             This allows you to specify a restriction to certain functions of an API by allowing control over POST (=Create), GET (=Read), PUT/PATCH (=Update) and DELETE (=Delete) methods for each API endpoint (URL) individually. * `resourcePermission`             In order to restrict access to specific resources create a role with `resourcePermission` type by specifying any number of [tags](#tag-management). These tags need to be assigned to resources for them to take effect. E.g. a tag could be assigned to several compute resources. So that a user with that role (and of course access to the API endpoints via `apiPermission` role type) could only access those compute resources.  The `roles` are then assigned to a `user`. You can assign one or several roles regardless of the role's type. Of course you could also assign a user `admin` privileges without specifying any roles.  ### [Tag Management](#tag/Tags)  The Tag Management API allows you to manage your tags in order to organize your resources in a more convenient way. Simply assign a tag to resources like a compute resource to manage them.The assignments of tags to resources will also enable you to control access to these specific resources to users via the [User Management API](#user-management). For convenience reasons you might choose a color for tag. The Customer Control Panel will use that color to display the tags.  ## Requests  The Contabo API supports HTTP requests like mentioned below. Not every endpoint supports all methods. The allowed methods are listed within this documentation.  Method | Description ---    | --- GET    | To retrieve information about a resource, use the GET method.<br>The data is returned as a JSON object. GET methods are read-only and do not affect any resources. POST   | Issue a POST method to create a new object. Include all needed attributes in the request body encoded as JSON. PATCH  | Some resources support partial modification with PATCH,<br>which modifies specific attributes without updating the entire object representation. PUT    | Use the PUT method to update information about a resource.<br>PUT will set new values on the item without regard to their current values. DELETE | Use the DELETE method to destroy a resource in your account.<br>If it is not found, the operation will return a 4xx error and an appropriate message.  ## Responses  Usually the Contabo API should respond to your requests. The data returned is in [JSON](https://www.json.org/) format allowing easy processing in any programming language or tools.  As common for HTTP requests you will get back a so called HTTP status code. This gives you overall information about success or error. The following table lists common HTTP status codes.  Please note that the description of the endpoints and methods are not listing all possibly status codes in detail as they are generic. Only special return codes with their resp. response data are explicitly listed.  Response Code | Description --- | --- 200 | The response contains your requested information. 201 | Your request was accepted. The resource was created. 204 | Your request succeeded, there is no additional information returned. 400 | Your request was malformed. 401 | You did not supply valid authentication credentials. 402 | Request refused as it requires additional payed service. 403 | You are not allowed to perform the request. 404 | No results were found for your request or resource does not exist. 409 | Conflict with resources. For example violation of unique data constraints detected when trying to create or change resources. 429 | Rate-limit reached. Please wait for some time before doing more requests. 500 | We were unable to perform the request due to server-side problems. In such cases please retry or contact the support.  Not every endpoint returns data. For example DELETE requests usually don't return any data. All others do return data. For easy handling the return values consists of metadata denoted with and underscore (\"_\") like `_links` or `_pagination`. The actual data is returned in a field called `data`. For convenience reasons this `data` field is always returned as an array even if it consists of only one single element.  Some general details about Contabo API from [Contabo](https://contabo.com).
 *
 * OpenAPI spec version: 1.0.0
 * Contact: support@contabo.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.46
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Contabo\ContaboSdk\Model;

use \ArrayAccess;
use \Contabo\ContaboSdk\ObjectSerializer;

/**
 * CreateObjectStorageResponseData Class Doc Comment
 *
 * @category Class
 * @package  Contabo\ContaboSdk
 * @author   Coderic Development Team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class CreateObjectStorageResponseData implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'CreateObjectStorageResponseData';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'tenant_id' => 'string',
        'customer_id' => 'string',
        'object_storage_id' => 'string',
        'created_date' => '\DateTime',
        'cancel_date' => '\DateTime',
        'auto_scaling' => 'AllOfCreateObjectStorageResponseDataAutoScaling',
        'data_center' => 'string',
        'total_purchased_space_tb' => 'double',
        'used_space_tb' => 'double',
        'used_space_percentage' => 'double',
        's3_url' => 'string',
        's3_tenant_id' => 'string',
        'status' => 'string',
        'region' => 'string',
        'display_name' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'tenant_id' => null,
        'customer_id' => null,
        'object_storage_id' => null,
        'created_date' => 'date-time',
        'cancel_date' => 'date',
        'auto_scaling' => null,
        'data_center' => null,
        'total_purchased_space_tb' => 'double',
        'used_space_tb' => 'double',
        'used_space_percentage' => 'double',
        's3_url' => null,
        's3_tenant_id' => null,
        'status' => null,
        'region' => null,
        'display_name' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'tenant_id' => 'tenantId',
        'customer_id' => 'customerId',
        'object_storage_id' => 'objectStorageId',
        'created_date' => 'createdDate',
        'cancel_date' => 'cancelDate',
        'auto_scaling' => 'autoScaling',
        'data_center' => 'dataCenter',
        'total_purchased_space_tb' => 'totalPurchasedSpaceTB',
        'used_space_tb' => 'usedSpaceTB',
        'used_space_percentage' => 'usedSpacePercentage',
        's3_url' => 's3Url',
        's3_tenant_id' => 's3TenantId',
        'status' => 'status',
        'region' => 'region',
        'display_name' => 'displayName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'tenant_id' => 'setTenantId',
        'customer_id' => 'setCustomerId',
        'object_storage_id' => 'setObjectStorageId',
        'created_date' => 'setCreatedDate',
        'cancel_date' => 'setCancelDate',
        'auto_scaling' => 'setAutoScaling',
        'data_center' => 'setDataCenter',
        'total_purchased_space_tb' => 'setTotalPurchasedSpaceTb',
        'used_space_tb' => 'setUsedSpaceTb',
        'used_space_percentage' => 'setUsedSpacePercentage',
        's3_url' => 'setS3Url',
        's3_tenant_id' => 'setS3TenantId',
        'status' => 'setStatus',
        'region' => 'setRegion',
        'display_name' => 'setDisplayName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'tenant_id' => 'getTenantId',
        'customer_id' => 'getCustomerId',
        'object_storage_id' => 'getObjectStorageId',
        'created_date' => 'getCreatedDate',
        'cancel_date' => 'getCancelDate',
        'auto_scaling' => 'getAutoScaling',
        'data_center' => 'getDataCenter',
        'total_purchased_space_tb' => 'getTotalPurchasedSpaceTb',
        'used_space_tb' => 'getUsedSpaceTb',
        'used_space_percentage' => 'getUsedSpacePercentage',
        's3_url' => 'getS3Url',
        's3_tenant_id' => 'getS3TenantId',
        'status' => 'getStatus',
        'region' => 'getRegion',
        'display_name' => 'getDisplayName'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    const STATUS_READY = 'READY';
    const STATUS_PROVISIONING = 'PROVISIONING';
    const STATUS_UPGRADING = 'UPGRADING';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_ERROR = 'ERROR';
    const STATUS_ENABLED = 'ENABLED';
    const STATUS_DISABLED = 'DISABLED';
    const STATUS_MANUAL_PROVISIONING = 'MANUAL_PROVISIONING';
    const STATUS_PRODUCT_NOT_AVAILABLE = 'PRODUCT_NOT_AVAILABLE';
    const STATUS_LIMIT_EXCEEDED = 'LIMIT_EXCEEDED';
    const STATUS_VERIFICATION_REQUIRED = 'VERIFICATION_REQUIRED';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_ORDER_PROCESSING = 'ORDER_PROCESSING';
    const STATUS_PENDING_PAYMENT = 'PENDING_PAYMENT';
    const STATUS_UNKNOWN = 'UNKNOWN';

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStatusAllowableValues()
    {
        return [
            self::STATUS_READY,
            self::STATUS_PROVISIONING,
            self::STATUS_UPGRADING,
            self::STATUS_CANCELLED,
            self::STATUS_ERROR,
            self::STATUS_ENABLED,
            self::STATUS_DISABLED,
            self::STATUS_MANUAL_PROVISIONING,
            self::STATUS_PRODUCT_NOT_AVAILABLE,
            self::STATUS_LIMIT_EXCEEDED,
            self::STATUS_VERIFICATION_REQUIRED,
            self::STATUS_COMPLETED,
            self::STATUS_ORDER_PROCESSING,
            self::STATUS_PENDING_PAYMENT,
            self::STATUS_UNKNOWN,
        ];
    }

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['tenant_id'] = isset($data['tenant_id']) ? $data['tenant_id'] : null;
        $this->container['customer_id'] = isset($data['customer_id']) ? $data['customer_id'] : null;
        $this->container['object_storage_id'] = isset($data['object_storage_id']) ? $data['object_storage_id'] : null;
        $this->container['created_date'] = isset($data['created_date']) ? $data['created_date'] : null;
        $this->container['cancel_date'] = isset($data['cancel_date']) ? $data['cancel_date'] : null;
        $this->container['auto_scaling'] = isset($data['auto_scaling']) ? $data['auto_scaling'] : null;
        $this->container['data_center'] = isset($data['data_center']) ? $data['data_center'] : null;
        $this->container['total_purchased_space_tb'] = isset($data['total_purchased_space_tb']) ? $data['total_purchased_space_tb'] : null;
        $this->container['used_space_tb'] = isset($data['used_space_tb']) ? $data['used_space_tb'] : null;
        $this->container['used_space_percentage'] = isset($data['used_space_percentage']) ? $data['used_space_percentage'] : null;
        $this->container['s3_url'] = isset($data['s3_url']) ? $data['s3_url'] : null;
        $this->container['s3_tenant_id'] = isset($data['s3_tenant_id']) ? $data['s3_tenant_id'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : null;
        $this->container['region'] = isset($data['region']) ? $data['region'] : null;
        $this->container['display_name'] = isset($data['display_name']) ? $data['display_name'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['tenant_id'] === null) {
            $invalidProperties[] = "'tenant_id' can't be null";
        }
        if ($this->container['customer_id'] === null) {
            $invalidProperties[] = "'customer_id' can't be null";
        }
        if ($this->container['object_storage_id'] === null) {
            $invalidProperties[] = "'object_storage_id' can't be null";
        }
        if ($this->container['created_date'] === null) {
            $invalidProperties[] = "'created_date' can't be null";
        }
        if ($this->container['cancel_date'] === null) {
            $invalidProperties[] = "'cancel_date' can't be null";
        }
        if ($this->container['auto_scaling'] === null) {
            $invalidProperties[] = "'auto_scaling' can't be null";
        }
        if ($this->container['data_center'] === null) {
            $invalidProperties[] = "'data_center' can't be null";
        }
        if ($this->container['total_purchased_space_tb'] === null) {
            $invalidProperties[] = "'total_purchased_space_tb' can't be null";
        }
        if ($this->container['used_space_tb'] === null) {
            $invalidProperties[] = "'used_space_tb' can't be null";
        }
        if ($this->container['used_space_percentage'] === null) {
            $invalidProperties[] = "'used_space_percentage' can't be null";
        }
        if ($this->container['s3_url'] === null) {
            $invalidProperties[] = "'s3_url' can't be null";
        }
        if ($this->container['s3_tenant_id'] === null) {
            $invalidProperties[] = "'s3_tenant_id' can't be null";
        }
        if ($this->container['status'] === null) {
            $invalidProperties[] = "'status' can't be null";
        }
        $allowedValues = $this->getStatusAllowableValues();
        if (!is_null($this->container['status']) && !in_array($this->container['status'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'status', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['region'] === null) {
            $invalidProperties[] = "'region' can't be null";
        }
        if ($this->container['display_name'] === null) {
            $invalidProperties[] = "'display_name' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets tenant_id
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->container['tenant_id'];
    }

    /**
     * Sets tenant_id
     *
     * @param string $tenant_id Your customer tenant id
     *
     * @return $this
     */
    public function setTenantId($tenant_id)
    {
        $this->container['tenant_id'] = $tenant_id;

        return $this;
    }

    /**
     * Gets customer_id
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->container['customer_id'];
    }

    /**
     * Sets customer_id
     *
     * @param string $customer_id Your customer number
     *
     * @return $this
     */
    public function setCustomerId($customer_id)
    {
        $this->container['customer_id'] = $customer_id;

        return $this;
    }

    /**
     * Gets object_storage_id
     *
     * @return string
     */
    public function getObjectStorageId()
    {
        return $this->container['object_storage_id'];
    }

    /**
     * Sets object_storage_id
     *
     * @param string $object_storage_id Your object storage id
     *
     * @return $this
     */
    public function setObjectStorageId($object_storage_id)
    {
        $this->container['object_storage_id'] = $object_storage_id;

        return $this;
    }

    /**
     * Gets created_date
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->container['created_date'];
    }

    /**
     * Sets created_date
     *
     * @param \DateTime $created_date Creation date for object storage.
     *
     * @return $this
     */
    public function setCreatedDate($created_date)
    {
        $this->container['created_date'] = $created_date;

        return $this;
    }

    /**
     * Gets cancel_date
     *
     * @return \DateTime
     */
    public function getCancelDate()
    {
        return $this->container['cancel_date'];
    }

    /**
     * Sets cancel_date
     *
     * @param \DateTime $cancel_date Cancellation date for object storage.
     *
     * @return $this
     */
    public function setCancelDate($cancel_date)
    {
        $this->container['cancel_date'] = $cancel_date;

        return $this;
    }

    /**
     * Gets auto_scaling
     *
     * @return AllOfCreateObjectStorageResponseDataAutoScaling
     */
    public function getAutoScaling()
    {
        return $this->container['auto_scaling'];
    }

    /**
     * Sets auto_scaling
     *
     * @param AllOfCreateObjectStorageResponseDataAutoScaling $auto_scaling Autoscaling settings
     *
     * @return $this
     */
    public function setAutoScaling($auto_scaling)
    {
        $this->container['auto_scaling'] = $auto_scaling;

        return $this;
    }

    /**
     * Gets data_center
     *
     * @return string
     */
    public function getDataCenter()
    {
        return $this->container['data_center'];
    }

    /**
     * Sets data_center
     *
     * @param string $data_center The data center of the storage
     *
     * @return $this
     */
    public function setDataCenter($data_center)
    {
        $this->container['data_center'] = $data_center;

        return $this;
    }

    /**
     * Gets total_purchased_space_tb
     *
     * @return double
     */
    public function getTotalPurchasedSpaceTb()
    {
        return $this->container['total_purchased_space_tb'];
    }

    /**
     * Sets total_purchased_space_tb
     *
     * @param double $total_purchased_space_tb Amount of purchased / requested object storage in TB.
     *
     * @return $this
     */
    public function setTotalPurchasedSpaceTb($total_purchased_space_tb)
    {
        $this->container['total_purchased_space_tb'] = $total_purchased_space_tb;

        return $this;
    }

    /**
     * Gets used_space_tb
     *
     * @return double
     */
    public function getUsedSpaceTb()
    {
        return $this->container['used_space_tb'];
    }

    /**
     * Sets used_space_tb
     *
     * @param double $used_space_tb Currently used space in TB.
     *
     * @return $this
     */
    public function setUsedSpaceTb($used_space_tb)
    {
        $this->container['used_space_tb'] = $used_space_tb;

        return $this;
    }

    /**
     * Gets used_space_percentage
     *
     * @return double
     */
    public function getUsedSpacePercentage()
    {
        return $this->container['used_space_percentage'];
    }

    /**
     * Sets used_space_percentage
     *
     * @param double $used_space_percentage Currently used space in percentage.
     *
     * @return $this
     */
    public function setUsedSpacePercentage($used_space_percentage)
    {
        $this->container['used_space_percentage'] = $used_space_percentage;

        return $this;
    }

    /**
     * Gets s3_url
     *
     * @return string
     */
    public function getS3Url()
    {
        return $this->container['s3_url'];
    }

    /**
     * Sets s3_url
     *
     * @param string $s3_url S3 URL to connect to your S3 compatible object storage
     *
     * @return $this
     */
    public function setS3Url($s3_url)
    {
        $this->container['s3_url'] = $s3_url;

        return $this;
    }

    /**
     * Gets s3_tenant_id
     *
     * @return string
     */
    public function getS3TenantId()
    {
        return $this->container['s3_tenant_id'];
    }

    /**
     * Sets s3_tenant_id
     *
     * @param string $s3_tenant_id Your S3 tenantId. Only required for public sharing.
     *
     * @return $this
     */
    public function setS3TenantId($s3_tenant_id)
    {
        $this->container['s3_tenant_id'] = $s3_tenant_id;

        return $this;
    }

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param string $status The object storage status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $allowedValues = $this->getStatusAllowableValues();
        if (!in_array($status, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'status', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->container['region'];
    }

    /**
     * Sets region
     *
     * @param string $region The region where your object storage is located
     *
     * @return $this
     */
    public function setRegion($region)
    {
        $this->container['region'] = $region;

        return $this;
    }

    /**
     * Gets display_name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->container['display_name'];
    }

    /**
     * Sets display_name
     *
     * @param string $display_name Display name for object storage.
     *
     * @return $this
     */
    public function setDisplayName($display_name)
    {
        $this->container['display_name'] = $display_name;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
