# RoleAuditResponse

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **int** | The identifier of the audit entry. | 
**action** | **string** | Type of the action. | 
**timestamp** | [**\DateTime**](\DateTime.md) | When the change took place. | 
**tenant_id** | **string** | Customer tenant id | 
**customer_id** | **string** | Customer number | 
**changed_by** | **string** | User ID | 
**username** | **string** | Name of the user which led to the change. | 
**request_id** | **string** | The requestId of the API call which led to the change. | 
**trace_id** | **string** | The traceId of the API call which led to the change. | 
**role_id** | **float** | The identifier of the role | 
**changes** | **object** | List of actual changes. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

