<x-mail::message>
# Job Application
<x-mail::table>
| Field                      | Value                                 |
| :------------------------- | :------------------------------------ |
| Job Position:              | {{$model->job_position}}              |
| First Name:                | {{$model->first_name}}                |
| Last Name:                 | {{$model->last_name}}                 |
| Phone:                     | {{$model->phone}}                     |
| Email:                     | {{$model->email}}                     |
</x-mail::table>
</x-mail::message>
