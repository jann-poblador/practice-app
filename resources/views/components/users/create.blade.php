<x-layout title="Add Users">
    <x-forms.dynamic-form title="Create New User" action="{{ route('users.store') }}" method="POST"
        submit-text="Create User" cancel-url="#" :fields="[
            [
                'name' => 'name',
                'label' => 'Full Name',
                'type' => 'text',
                'required' => 'true',
                'placeholder' => 'Enter full name',
            ],
            [
                'name' => 'email',
                'label' => 'Email Address',
                'type' => 'email',
                'required' => true,
                'placeholder' => 'user@example.com',
            ],
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'required' => true,
                'help' => 'Minimum 8 characters',
            ],
            [
                'name' => 'role',
                'label' => 'User Role',
                'type' => 'select',
                'required' => true,
                'placeholder' => 'Select role',
                'options' => $roles,
            ],
            [
                'name' => 'active',
                'label' => 'Account Status',
                'type' => 'checkbox',
                'value' => 1,
                'description' => 'Account is active',
            ],
        ]" />
</x-layout>
