
{{ content() }}

<div class="page-header">
    <h2>Escreva-se no Wepeer</h2>
</div>

{{ form('register', 'id': 'registerForm', 'onbeforesubmit': 'return false') }}

    <fieldset>

        <div class="control-group">
            {{ form.label('name', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('name', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="name_alert">
                    <strong>Warning!</strong> Por favor digite seu nome completo!
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('cpf', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('cpf', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="cpf_alert">
                    <strong>Warning!</strong> Digite seu nome de usuário desejado
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('data_nas', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('data_nas', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="data_nas_alert">
                    <strong>Warning!</strong> Digite a data de seu nascimento
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('email', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('email', ['class': 'form-control']) }}
                <div class="alert alert-warning" id="email_alert">
                    <strong>Warning!</strong> Por favor introduza o seu e-mail
                </div>
            </div>
        </div>

        <div class="control-group">
            {{ form.label('password', ['class': 'control-label']) }}
            <div class="controls">
                {{ form.render('password', ['class': 'form-control']) }}
                <p class="help-block">(Mínimo 8 caracteres)</p>
                <div class="alert alert-warning" id="password_alert">
                    <strong>Warning!</strong> Fornecer uma senha válida
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="repeatPassword">Repeat Password</label>
            <div class="controls">
                {{ password_field('repeatPassword', 'class': 'input-xlarge') }}
                <div class="alert" id="repeatPassword_alert">
                    <strong>Warning!</strong> A senha não corresponde
                </div>
            </div>
        </div>
        

        <div class="form-actions">
            {{ submit_button('Enviar cadastro', 'class': 'btn btn-primary', 'onclick': 'return SignUp.validate();') }}
            <p class="help-block">Ao se inscrever, você aceita termos de uso e política de privacidade.</p>
        </div>

    </fieldset>
</form>
