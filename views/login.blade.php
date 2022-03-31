<?= Form::open(['url' => \Backend::url('lucacalcaterra/ldapauth/ldap/signin')]) ?>
<input type="hidden" name="postback" value="1" />

<div class="form-elements" role="form">
    <div class="form-group text-field horizontal-form">

        <!-- Login -->
        <input type="text" name="login" value="<?= e(post('login')) ?>" class="form-control icon user"
            placeholder="<?= e(trans('backend::lang.account.login_placeholder')) ?>" autocomplete="off"
            maxlength="255" />

        <!-- Password -->
        <input type="password" name="password" value="" class="form-control icon lock"
            placeholder="<?= e(trans('backend::lang.account.password_placeholder')) ?>" autocomplete="off"
            maxlength="255" />

        <!-- Submit Login -->
        <button type="submit" class="btn btn-primary login-button">
            <?= e(trans('backend::lang.account.login')) ?>
        </button>
    </div>

</div>
<?= Form::close() ?>
