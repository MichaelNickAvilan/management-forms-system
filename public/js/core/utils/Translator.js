(
    function(){
        let Translator = {
            a_lang:'ES',
            a_keys:[],
            init:function(){
               const urlParams = new URLSearchParams(window.location.search);
               if(urlParams.get('lang') != null ){
                const urlParams = new URLSearchParams(window.location.search);
                Translator.a_lang = urlParams.get('lang');
                localStorage.setItem('lang', Translator.a_lang);
               }else{
                if(localStorage.getItem('lang') != null){
                    Translator.a_lang = localStorage.getItem('lang');
                }
               }
               Translator.a_keys = Translator.getKeys();
               Translator.translateInterface();
            },
            translateInterface:function(){
                if(Translator.a_lang!='ES'){
                    Translator.translateByTagType('h1');
                    Translator.translateByTagType('h2');
                    Translator.translateByTagType('p');
                    Translator.translateByTagType('button');
                    Translator.translateByTagType('label');
                    Translator.translateByTagType('input');
                    Translator.translateByTagType('span');
                }
            },
            translateByTagType:function(type){
                let items = Array.from(document.getElementsByTagName(type));
                items.forEach((item)=>{
                    Translator.a_keys.forEach((key)=>{
                        if(type === 'input'){
                            if(item.placeholder.indexOf(key.es)>=0){
                                item.placeholder = key[Translator.a_lang.toLowerCase()];
                            }
                        }
                        if(item.textContent.indexOf(key.es)>=0){
                            item.textContent = key[Translator.a_lang.toLowerCase()];
                        }
                    });
                });
            },
            getKeys:function(){
                return [
                    { es:'Sistema de evaluación y seguimiento', bra:'Sistema de avaliação e monitoramento' },
                    { es:'Recuerdame', bra:'Lembre de mim' },
                    { es:'Login', bra:'Conecte-se' },
                    { es:'E-Mail Address', bra:'Endereço de email' },
                    { es:'Password', bra:'Senha' },
                    { es:'Compañías', bra:'Empresas' },
                    { es:'Sistemas', bra:'Sistemas' },
                    { es:'Formularios', bra:'Formulários' },
                    { es:'Campos', bra:'Campos' },
                    { es:'Usuarios', bra:'Usuarios' },
                    { es:'Gestionar usuarios', bra:'Gerenciar usuários' },
                    { es:'Crear usuario', bra:'Criar usuário' },
                    { es:'Importar usuarios', bra:'Importar usuários' },
                    { es:'Gestionar sistemas', bra:'Gerenciar sistemas' },
                    { es:'Crear sistema', bra:'Criar sistema' },
                    { es:'Gestionar formularios', bra:'Gerenciar formulários' },
                    { es:'Crear formulario', bra:'Criar formulário' },
                    { es:'Gestionar campos', bra:'Gerenciar campos' },
                    { es:'Crear campo', bra:'Criar campo' },
                    { es:'Descargar reporte', bra:'Baixar relatório' },
                    { es:'Buscar evaluaciones de mis usuarios', bra:'Encontrar comentários de meus usuários' },
                    { es:'Evaluar usuario', bra:'Avaliar usuário' },
                    { es:'Ver evaluaciones del usuario', bra:'Ver comentários de usuários' },
                    { es:'Actualizar usuario', bra:'Atualizar usuário' },
                    { es:'Eliminar usuario', bra:'Excluir usuário' },
                    { es:'Opciones de configuración', bra:'Opções de configuração' },
                    { es:'Listado de compañías', bra:'Lista de empresas' },
                    { es:'En esta sección podrás gestionar las compañías existentes en el sistema.', bra:'Nesta seção você pode gerenciar as empresas existentes no sistema.' },
                    { es:'Listado de sistemas', bra:'Lista de sistemas' },
                    { es:'En esta sección podrás gestionar los sistemas asociados a una compalía.', bra:'Nesta seção você pode gerenciar os sistemas associados a uma empresa.' },
                    { es:'Listado de formularios', bra:'Lista de formulários' },
                    { es:'En esta sección podrás gestionar los formularios asociados a un sistema.', bra:'Nesta seção você pode gerenciar os formulários associados a um sistema.' },
                    { es:'Listado de campos', bra:'Lista de campos' },
                    { es:'En esta sección podrás gestionar los campos asociados a un formulario.', bra:'Nesta seção você pode gerenciar os campos associados a um formulário.' },
                    { es:'Listado de usuarios', bra:'Lista de usuários' },
                    { es:'En esta sección podrás gestionar los usuarios existentes en el sistema.', bra:'Nesta seção você pode gerenciar os usuários existentes no sistema.' },
                    { es:'Encuentra registros', bra:'Encontrar registros' },
                    { es:'Un registro se compone de múltiples campos pertenecientes a un formulario de un sistema.', bra:'Um registro é composto por vários campos pertencentes a um formulário em um sistema.' },
                    { es:'Registra una compañía', bra:'Cadastre uma empresa' },
                    { es:'Una compañía se define como el nivel superior de categorización de uno o varios sistemas.', bra:'Uma empresa é definida como o nível mais alto de categorização de um ou mais sistemas.' },
                    { es:'Registrar compañía.', bra:'Cadastre-se empresa.' },
                    { es:'Detalles de la compañía', bra:'Detalhes da empresa' },
                    { es:'En esta sección podrás ver los detalles de la compañía seleccionada, también es posible continuar con su edición o también optar por su eliminación del sistema.', bra:'Nesta seção você poderá ver os dados da empresa selecionada, também é possível continuar editando-a ou também optar por excluí-la do sistema.' },
                    { es:'Actualizar compañía', bra:'Atualizar empresa' },
                    { es:'Eliminar compañía', bra:'Excluir empresa' },
                    { es:'Detalles del sistema', bra:'Detalhes do sistema' },
                    { es:'En esta sección podrás ver los detalles del sistema, también es posible continuar con su edición o también optar por su eliminación del sistema.', bra:'Nesta seção você poderá ver os detalhes do sistema, também é possível continuar editando-o ou também optar por excluí-lo do sistema.' },
                    { es:'Actualizar sistema', bra:'Atualizar sistema' },
                    { es:'Eliminar sistema', bra:'Excluir sistema' },
                    { es:'Actualizar una compañía', bra:'Atualizar uma empresa' },
                    { es:'En esta sección podrás editar cualquier detalle de la comañía seleccionada.', bra:'Nesta seção você pode editar quaisquer detalhes da empresa selecionada.' },
                    { es:'Detalles del formulario', bra:'Detalhes do formulário' },
                    { es:'En esta sección podrás ver los detalles del formulario seleccionado, también es posible continuar con su edición o también optar por su eliminación del sistema.', bra:'Nesta seção você poderá ver os detalhes do formulário selecionado, também é possível continuar editando-o ou também optar por excluí-lo do sistema.' },
                    { es:'Actualizar formulario', bra:'Atualizar formulário' },
                    { es:'Eliminar formulario', bra:'Excluir formulário' },
                    { es:'Actualizar un formulario', bra:'Atualizar um formulário' },
                    { es:'En esta sección podrás editar los detalles del formulario seleccionado.', bra:'Nesta seção você pode editar os detalhes do formulário selecionado.' },
                    { es:'Detalles del campo', bra:'Detalhes do campo' },
                    { es:'Un campo pertenece a un formulario y es la base para la recolección de registros.', bra:'Um campo pertence a um formulário e é a base para a coleta de registros.' },
                    { es:'Actualizar campo', bra:'Atualizar campo' },
                    { es:'Eliminar campo', bra:'Excluir campo' },
                    { es:'Actualizar un campo', bra:'Atualizar um campo' },
                    { es:'Un campo pertenece a un formulario y es la base para la recolección de registros.', bra:'Um campo pertence a um formulário e é a base para a coleta de registros.' },
                    { es:'En esta sección podrás actualizar los detalles del usuario.', bra:'Nesta seção você pode atualizar os detalhes do usuário.' },
                    { es:'Crear registro', bra:'Criar registro' },
                    { es:'Usuarios', bra:'Usuários' },
                    { es:'Tienda', bra:'Loja' },
                    { es:'Nombres', bra:'Nomes' },
                    { es:'Apellidos', bra:'Sobrenomes' },
                    { es:'Email', bra:'E-mail' },
                    { es:'Tipo de usuario', bra:'Tipo de usuário' },
                    { es:'Detalles', bra:'Detalhes' },
                    { es:'Rol', bra:'Papel' },
                    { es:'Código de la tienda', bra:'Código da loja' },
                    { es:'Identificación del usuario', bra:'ID do usuário' },
                    { es:'Sistema', bra:'Sistema' },
                    { es:'Enlace', bra:'Link' },
                    { es:'Compañía', bra:'Empresa' },
                    { es:'Nombre del sistema', bra:'Nome do sistema' },
                    { es:'Descripción del sistema', bra:'Descrição do sistema' },
                    { es:'URL o enlace del sistema', bra:'URL ou link do sistema' },
                    { es:'Nombre de la compañía', bra:'Nome da empresa' },
                    { es:'Id formulario', bra:'ID do formulário' },
                    { es:'Sistema', bra:'Sistema' },
                    { es:'Nombre formulario', bra:'Nome do formulário' },
                    { es:'Nombre del formulario', bra:'Nome do formulário' },
                    { es:'Descripción del formulario', bra:'Descrição do formulário' },
                    { es:'Registra un formulario', bra:'Cadastre um formulário' },
                    { es:'Una formulario pertenece a un sistema y define una agrupación de campos.', bra:'Um formulário pertence a um sistema e define um agrupamento de campos.' },
                    { es:'Formulario', bra:'Forma' },
                    { es:'Campo', bra:'Campo' },
                    { es:'Correo electrónico del usuario', bra:'E-mail do usuário' },
                    { es:'Ver usuario', bra:'Ver usuário' },
                    { es:'Buscar todos los registros', bra:'Encontre todos os registros' },
                ];
            }
        }
        setTimeout(function() {
            Translator.init();
        }, 1000);
        
    }
)();