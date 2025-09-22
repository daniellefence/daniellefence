<x-mail::message>
# Contact Request
<x-mail::table>
| Field                      | Value                                 |
| :------------------------- | :------------------------------------ |
| First Name:                | {{$model->first_name}}                |
| Last Name:                 | {{$model->last_name}}                 |
| Company:                   | {{$model->company}}                   |
| Email:                     | {{$model->email}}                     |
| Phone:                     | {{$model->phone}}                     |
| Message:                   | {{$model->message}}                   |
| How did you hear about us: | {{$model->how_did_you_hear_about_us}} |
</x-mail::table>
</x-mail::message>
