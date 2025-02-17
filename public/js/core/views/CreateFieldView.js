var CreateFieldView={
    a_field:null,
    a_forms_combo:null,
    a_systems:[],
    a_user:[],
    init:function(){
        CreateFieldView.addListeners();
    },
    addListeners:function(){
        var systems_combo=document.getElementById('systems_combo');
        if(systems_combo!=null){
            systems_combo.addEventListener('change', this.systemSelected);
        }
    },
    systemSelected:function(e=null){
        var forms_combo = document.getElementById('forms_combo');
        if(e!=null){
            if(e.currentTarget.value.length>0){
                forms_combo.innerHTML = CreateFieldView.getFormsOptions(e.currentTarget.value);
            }
        }else{
            var systems_combo=document.getElementById('systems_combo');
            if(String(systems_combo.value).length>0){
                forms_combo.innerHTML = CreateFieldView.getFormsOptions(systems_combo.value);
            }
        }
    },
    getFormsOptions:function(id){
        var options = '<option value="" >Seleccione una opción</option>';
        var forms_combo = document.getElementById('forms_combo');
        for(var i=0;i<CreateFieldView.a_systems.length;i++){
            if(Number(CreateFieldView.a_systems[i].id_system) === Number(id)){
                for(var j=0;j<CreateFieldView.a_systems[i].forms.length;j++){
                    if(CreateFieldView.a_field!=null && CreateFieldView.a_systems[i].forms[j].id_form === CreateFieldView.a_field.id_form){
                        options += '<option value="'+
                        CreateFieldView.a_systems[i].forms[j].id_form+
                        '" selected>';
                    }else{
                        options += '<option value="'+
                        CreateFieldView.a_systems[i].forms[j].id_form+
                        '">';
                    }
                    options+=
                    CreateFieldView.a_systems[i].forms[j].name_form
                    +'</option>'
                }
                return options;
            }
        }
    }
};
CreateFieldView.init();
