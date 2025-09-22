<x-mail::message>
# Outdoor Spaces Quote Request
| Field                 | Value                            |
| :-------------------- | :------------------------------- |
| Product Name:         | {{$model->product_name}}         |
| Design Options:       | {{$model->design_options}}       |
| Size of Area:         | {{$model->size_of_area}}         |
| Will you need pavers: | {{$model->will_you_need_pavers}} |
| Features:             | {{$model->features}}             |
| Additional Comments:  | {{$model->additional_comments}}  |
| First Name:           | {{$model->first_name}}           |
| Last Name:            | {{$model->last_name}}            |
| Phone:                | {{$model->phone_number}}                |
| Email:                | {{$model->email}}                |
| Address Line One:     | {{$model->address_line_one}}     |
| Address Line Two:     | {{$model->address_line_two}}     |
| City:                 | {{$model->city}}                 |
| State:                | {{$model->state}}                |
| Zip Code:             | {{$model->zip_code}}             |
</x-mail::message>
