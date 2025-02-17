var Registers = {
    a_fields:[],
    a_rich_editors:[],
    a_registers:[],
    a_titles:[],
    a_current_system_id:0,
    a_data_tables:[],
    init:function(){
        Registers.addListeners();
        if(Registers.a_registers.length>0){
            var systems_combo = document.getElementById('systems_combo');
            var forms_combo = document.getElementById('forms_combo');
            if(systems_combo!=null && forms_combo!=null){
                for(var i=0;i<systems_combo.children.length;i++){
                    if(systems_combo.children[i].value == Registers.a_current_system_id){
                        systems_combo.selectedIndex = i;
                    }
                }
                CreateFieldView.systemSelected();
                forms_combo.value = Registers.getSelectedForm().id_form;
            }else{
                if(document.location.href.indexOf('edit')>=0){
                    Registers.renderFields(Registers.a_form.fields, 'fields_container', Registers.a_form.id_form);
                }else{
                    Registers.renderFields(Registers.a_form.fields, 'fields_container', Registers.a_form.id_form, 'disabled');
                }
            }
        }
    },
    addListeners:function(){
        var forms_combo = document.getElementById('forms_combo');
        if(forms_combo!=null){
            forms_combo.addEventListener('change', Registers.formSelected);
        }
    },
    formSelected:function(e=null){
        let ct = document.getElementById('fields_container');
        if(ct != null){
            Registers.a_fields = Registers.getSelectedForm().fields;
            Registers.renderFields(Registers.a_fields, 'fields_container', Registers.getSelectedForm().id_form);
        }else{
            if(document.location.search.indexOf('user_id')>=0){
                let params = new URLSearchParams(location.search);
                let regs_link = document.getElementById('regs_link');
                let regs_link_all = document.getElementById('regs_link_all');
                regs_link.setAttribute('href', document.location.origin+'/registers?id_form='+e.target.value+'&email='+params.get('email')+'&user_id='+params.get('user_id'));
                regs_link_all.setAttribute('href', document.location.origin+'/registers?id_form='+e.target.value);
            }else{
                let regs_link = document.getElementById('regs_link');
                regs_link.setAttribute('href', document.location.origin+'/registers?id_form='+e.target.value);
            }
        }
    },
    getSelectedForm:function(){
        var forms_combo = document.getElementById('forms_combo');
        for(var i=0;i<CreateFieldView.a_systems.length;i++){
            for(var j=0;j<CreateFieldView.a_systems[i].forms.length;j++){
                if(forms_combo.value!=''){
                    if(Number(CreateFieldView.a_systems[i].forms[j].id_form) === Number(forms_combo.value)){
                        return CreateFieldView.a_systems[i].forms[j];
                    }
                }else{
                    if(Registers.a_registers.length>0){
                        if(Number(CreateFieldView.a_systems[i].forms[j].id_form) === Number(Registers.a_registers[0].id_form)){
                            return CreateFieldView.a_systems[i].forms[j];
                        }
                    }
                }
            }
        }
    },
    renderFields:function(fields, container, id_form, disabled=''){
        var contents = '';
        var rich_texts = [];
        var rich_texts_values = [];
        let categories = [];
        var conectar_centinela = false;
        var container = document.getElementById(container);
        var contacto_centinela = false;
        var establece_centinela = false;
        var reconecta_centinela = false;
        var atencion_centinela = false;
        var comprometer_centinela = false;
        var descubrir_centinela = false;
        var recomendar_centinela = false;
        var invitar_centinela = false;
        var opciones_centinela = false;
        var adicionales_centinela = false;
        var objeciones_centinela = false;
        var key_categories = [];

        if(container!=null){
            var current_pos = 0;
            for(var i=0;i<fields.length;i++){
                var value = '';
                var _labels = Registers.getLabels(fields[i].name_field);
                if(i%5 === 0){
                    current_pos = i;
                    contents+='<div class="row">';
                    if(fields[i].name_field.indexOf('Conectar')>=0){
                        if(conectar_centinela === false){
                            conectar_centinela = true;
                            contents += _labels.title;
                        }
                        if(Registers.isTitle(categories)){
                            contents += _labels.category;
                            categories.push(_labels.category);
                        }
                    }
                    if(fields[i].name_field.indexOf('Comprometer')>=0){
                        if(comprometer_centinela === false){
                            comprometer_centinela = true;
                            contents += _labels.title;
                        }
                        if(Registers.isTitle(categories)){
                            contents += _labels.category;
                            categories.push(_labels.category);
                        }
                    }
                }
                if(fields[i].value != undefined){
                    value='value="'+fields[i].value.value_register+'"';
                }
                switch(fields[i].type_field){
                    case 'text':
                        if(fields[i].settings_field != null){
                            let field_settings = JSON.parse(fields[i].settings_field);
                            switch(field_settings.type){
                                case 'dynamic_text':
                                    if(field_settings.source.type === 'queryparam'){
                                        let urlParams = new URLSearchParams(window.location.search);
                                        contents+='<div class="col-lg-6" style="visibility:hidden; height:0px;">';
                                        contents+='<div class="form-group">';
                                        /*contents+='<label style="visibility:hidden; height:0px; widht:0px; padding:0px;" class="form-control-label" for="'+fields[i].id_field+'_input">'+_labels.label+'<span class="small text-danger">*</span></label>';*/
                                        contents+='<input style="visibility:hidden;" type="text" '+value+' class="form-control form-control-user" name="'+fields[i].id_field+
                                        '_text" placeholder="" value="'+ urlParams.get( field_settings.source.param ) +'" required autofocus '+disabled+'>';
                                        contents+='</div></div>';
                                    }
                                break;
                                case 'combo':
                                    if(fields[i].description_field != '.'){
                                        contents+='<div class="col-lg-12">';
                                    }else{
                                        contents+='<div class="col-lg-12">';
                                    }
                                    contents+='<div class="form-group">';
                                    contents+=`
                                    <label class="form-control-label" for="'+fields[i].id_field+'_input">
                                        ${_labels.label}<span class="small text-danger">*
                                        </span>
                                    </label>
                                    `;
                                    if(fields[i].description_field != '.'){
                                        let desc = window.btoa(fields[i].description_field);
                                        contents+=`
                                        `;
                                        contents+=`
                                        <div>
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td style="width:20px;">
                                                    <div onclick="Registers.showDescription('${desc}');" class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                    </div>
                                                    </td>
                                                    <td style="padding:10px;">
                                                            <select name="${fields[i].id_field}_text" class="form-control form-control-user" ${disabled} required>
                                                                ${Registers.getCombo(field_settings)}
                                                            </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>`;
                                    }else{
                                        contents+='<div><select name="'+fields[i].id_field+'_text" class="form-control form-control-user" '+disabled+'>'+
                                        Registers.getCombo(field_settings)+'</select></div>';
                                    }
                                    contents+='</div></div>';
                                break;
                                case 'title':
                                    contents+='<div class="col-lg-12">';
                                    contents+='<div class="form-group">';
                                    if(field_settings.styles != undefined){
                                        contents+= '<div class="col-lg-12 formTitle" style="padding-top: 15px;'+ field_settings.styles +'"><p>'+_labels.label+'</p></div>';
                                    }else{
                                        contents+= '<div class="col-lg-12 formTitle" style="padding-top: 15px;"><p>'+_labels.label+'</p></div>';
                                    }
                                    contents+='</div></div>';
                                break;
                            }
                        }else{
                            contents+='<div class="col-lg-6">';
                            contents+='<div class="form-group">';
                            contents+='<br/><label class="form-control-label" for="'+fields[i].id_field+'_input">'+_labels.label+'<span class="small text-danger">*</span></label>';
                            contents+='<br/><div class="form-control-label" style="font-style: italic;color: #999797;width: 100%; border-color: white;">'+fields[i].description_field+'</div><br/>';
                            contents+='<input type="text" '+value+' class="form-control form-control-user" name="'+fields[i].id_field+'_text" placeholder="" required autofocus '+disabled+'>';
                            contents+='</div></div>';
                        }
                    break;
                    case 'text_area':
                        if(fields[i].value != undefined){
                            value = fields[i].value.value_register;
                        }
                        contents+='<textarea placeholder="'+fields[i].name_field+'" style="padding: 20px; margin-bottom: 11px;" class="form-control form-control-user" name="'+fields[i].id_field+'_text_area" autofocus '+disabled+'>'+value+'</textarea>'
                    break;
                    case 'rich_text':
                        if(disabled===''){
                            contents+=
                            '<input type="hidden" id="'+fields[i].id_field+'_container_hidden" name="'+fields[i].id_field+'_container_hidden">'+
                            '<textarea id="'+fields[i].id_field+'_container"></textarea>';
                            rich_texts.push(fields[i].id_field+'_container');
                            if(fields[i].value!=undefined && fields[i].value!=null){
                                rich_texts_values.push(fields[i].value.value_register);
                            }
                        }else{
                            contents+=fields[i].value.value_register;
                        }
                    break;
                    case 'number':
                        contents+='<input type="number" '+value+' class="form-control form-control-user" name="'+fields[i].id_field+'_text" placeholder="" required autofocus '+disabled+'>';
                    break;
                    case 'date':
                        contents+='<input type="date" '+value+' class="form-control form-control-user" name="'+fields[i].id_field+'_text" placeholder="" required autofocus '+disabled+'>';
                    break;
                    case 'image':
                        if(disabled===''){
                            if(fields[i].value!=undefined && fields[i].value!=null){
                                contents+='<br/><img height="60" src="/storage/registers/'+fields[i].value.value_register+'"/><br/><br/>';
                            }
                            if(document.location.href.indexOf('edit')>=0){
                                contents+='<input type="file" class="form-control form-control-user" name="'+fields[i].id_field+'_image"/>';
                            }else{
                                contents+='<input type="file" class="form-control form-control-user" name="'+fields[i].id_field+'_image" required autofocus/>';
                            }
                        }else{
                            contents+='<br/><img height="60" src="/storage/registers/'+fields[i].value.value_register+'"/>';
                        }
                    break;
                    case 'file':
                        if(disabled===''){
                            if(fields[i].value!=undefined && fields[i].value!=null){
                                contents+='<br/><a href="/storage/registers/'+fields[i].value.value_register+'" download> Descargar archivo <a/><br/><br/>';
                            }
                            if(document.location.href.indexOf('edit')>=0){
                                contents+='<input type="file" class="form-control form-control-user" name="'+fields[i].id_field+'_image"/>';
                            }else{
                                contents+='<input type="file" class="form-control form-control-user" name="'+fields[i].id_field+'_image" required autofocus/>';
                            }
                        }else{
                            contents+='<br/><a href="/storage/registers/'+fields[i].value.value_register+'" download> Descargar archivo <a/><br/><br/>';
                        }
                    break;
                }
                if(i === (current_pos+4)){
                    contents+='</div>';    
                }
            }
            container.innerHTML= contents;
            Registers.initializeRichTextEditors(rich_texts, rich_texts_values);
        }
        
        Registers.buildTables();
        Registers.assignValues();
    },
    showDescription:function(description){
        Swal.fire({
            html: `${window.atob(description)}`
          });
    },
    buildTables:function(){
        try{
           /* DataTablesUtils.init('st_table_0');
            DataTablesUtils.init('st_table_1');
            DataTablesUtils.init('st_table_2');*/
        }catch(e){
        }finally{}
    },
    assignValues:function(){
        if(Registers.a_registers.length>0){
            Registers.a_registers.forEach((register)=>{
                register.values.forEach((value)=>{
                    let el = document.getElementsByName(value.id_field+'_text')[0];
                    if(el != undefined){
                        el.setAttribute('value',value.value_register);
                        el.value = value.value_register;
                    }
                });
            });
        }
    },
    getCombo:function(settings){
        var html = '';
        for(var i=0;i<settings.options.length;i++){
            html+='<option value="'+settings.options[i].value+'" >'+settings.options[i].label+'</option>'
        }
        return html;
    },
    isTitle:function(categories, category){
        for(var i=0; i<categories.length;i++){
            if(categories[i] === category){
                return false;
            }
        }
        return true;
    },
    getLabels:function(_label){
        let labels = { original : _label, label : '', title : '', category : '' };
        if(_label.split('-').length===3){
            labels.label = _label.split(' - ')[2];
            labels.title = '<div class="col-lg-12 formTitle" style="padding-top: 15px;"><p>'+_label.split(' - ')[0]+'</p></div>';
            labels.category = '<div class="col-lg-12" style="padding-top: 15px;"><p>'+_label.split(' - ')[1]+'</p><hr class="sidebar-divider d-none d-md-block"></div>';
        }else{
            labels.label = _label;
        }
        return labels;
    },
    getOptions:function(field){
        options = field.description_field.split(',');
        html='';
        for(var i=0;i<options.length;i++){
            html+='<option value="'+options[i]+'" >'+options[i]+'</option>'
        }
        return html;
    },
    initializeRichTextEditors:function(rich_texts, values){
        for(var i=0;i<rich_texts.length;i++){
            $( '#'+rich_texts[i] ).ckeditor();
            if(values.length>0){
                if(values[i]!=undefined){
                    CKEDITOR.instances[rich_texts[i]].setData(values[i]);
                    var hidden = document.getElementById(rich_texts[i]+'_hidden');
                    hidden.value = CKEDITOR.instances[rich_texts[i]].getData();
                }
            }

            CKEDITOR.instances[rich_texts[i]].on('change', function(e) {
                var hidden = document.getElementById(e.editor.name+'_hidden');
                hidden.value = CKEDITOR.instances[e.editor.name].getData();
            });
        }
    }
};
