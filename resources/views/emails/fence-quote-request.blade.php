<x-mail::message>
# Fence Quote Request
## User Details
- **First Name:**  {{$model->first_name}}
- **Last Name:**  {{$model->last_name}}
- **Email:**  {{$model->email}}
- **Phone Number:**  {{$model->phone_number}}
- **Address Line One:**  {{$model->address_line_one}}
- **Address Line Two:**  {{$model->address_line_two}}
- **City:**  {{$model->city}}
- **State:**  {{$model->state}}
- **Zip Code:**  {{$model->zip_code}}
## Request Details
- **Fence Type:**  {{$model->fence_type}}
- **Product Name:**  {{$model->product_name}}
- **Linear Footage:**  {{$model->linear_footage}}
- **Style Options:**  {{$model->style_options}}
- **Will you need us to take down and haul away existing fence?**  {{$model->haul_away}}
- **What height fence do you need?**  {{$model->fence_height}}
- **How many gates do you need?**  {{$model->how_many_gates}}
- **Additional Comments:**  {{$model->additional_comments}}
</x-mail::message>
