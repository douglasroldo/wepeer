
{{ content() }}

<div class="row">

    <div class="col-md-6">
        <div class="page-header">
            <h2>Fazer Login</h2>
        </div>
        {{ form('session/start', 'role': 'form') }}
            <fieldset>
                <div class="form-group">
                    <label for="email">Email do Usuário</label>
                    <div class="controls">
                        {{ text_field('email', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    {{ submit_button('Login', 'class': 'btn btn-primary btn-large') }}
                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-6">

        <div class="page-header">
            <h2>Não tem uma conta ainda?</h2>
        </div>

        <p>Criar uma conta oferece as seguintes vantagens:</p>
        <ul>
            <li>Criação de peers </li>
            <li>Poderá responder peers ja cadastrados</li>
        </ul>

        <div class="clearfix center">
            {{ link_to('register', 'Cadastrar-se', 'class': 'btn btn-primary btn-large btn-success') }}
        </div>
    </div>

</div>
