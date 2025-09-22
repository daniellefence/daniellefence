<x-mail::message>
# Pavers Quote Request
| Field                            | Value                                       |
| :------------------------------- | :------------------------------------------ |
| Paver Type:                      | {{$model->paver_type}}                      |
| Product Name:                    | {{$model->product_name}}                    |
| Color Options:                   | {{$model->color_options}}                   |
| Size of Area:                    | {{$model->size_of_area}}                    |
| What will this area be used for: | {{$model->what_will_this_area_be_used_for}} |
| Additional Comments:             | {{$model->additional_comments}}             |
| First Name:                      | {{$model->first_name}}                      |
| Last Name:                       | {{$model->last_name}}                       |
| Phone:                           | {{$model->phone_number}}                    |
| Email:                           | {{$model->email}}                           |
| Address Line One:                | {{$model->address_line_one}}                |
| Address Line Two:                | {{$model->address_line_two}}                |
| City:                            | {{$model->city}}                            |
| State:                           | {{$model->state}}                           |
| Zip Code:                        | {{$model->zip_code}}                        |
</x-mail::message>
