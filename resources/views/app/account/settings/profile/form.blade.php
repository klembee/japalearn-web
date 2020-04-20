<form method="post" action="{{route('account.profile.update')}}" enctype="multipart/form-data" novalidate class="md-layout">
    @csrf

    <md-card class="md-layout-item mt-3 md-size-50 md-small-size-100">
        <md-card-header>
            <div class="md-title">Edit profile</div>
        </md-card-header>

        <md-card-content>
            <md-field>
                <label for="name">Name</label>
                <md-input name="name" id="name" value="{{$user->name}}"/>
            </md-field>
            <md-field>
                <label for="email">Email (Can't change)</label>
                <md-input readonly id="email" value="{{$user->email}}"/>
            </md-field>

            <md-subheader>Change password</md-subheader>
            <md-field>
                <label for="password">New password</label>
                <md-input readonly onclick="this.removeAttribute('readonly')" name="password" type="password" id="password"/>
            </md-field>
            <md-field>
                <label for="password_conf">Confirm new password</label>
                <md-input readonly onclick="this.removeAttribute('readonly')" name="password_conf" type="password" id="password_conf"/>
            </md-field>

            <md-subheader>Profile picture</md-subheader>
            <md-field>
                <label>Upload a new picture</label>
                <md-file name="picture"></md-file>
            </md-field>

            <md-button type="submit">{{__('Save profile')}}</md-button>

        </md-card-content>
    </md-card>
</form>