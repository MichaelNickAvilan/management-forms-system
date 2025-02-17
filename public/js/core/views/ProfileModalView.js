let ProfileModalView = {
    init:function(_formName){
        ProfileModalView._getGroupedEvals(UserProfile.a_evaluations,_formName, 'Usuario a evaluar');
    },
    reset:function(){
        let users_summary = document.getElementById('users_summary');
        users_summary.innerHTML = '';
        let summary_container = document.getElementById('summary_container');
        summary_container.style.visibility = 'hidden';
    },
    _getGroupedEvals(evals, formName, fieldTitle){
        let filteredEvals = [];
        let users = [];
        evals.forEach((eval)=>{
            if(eval.name_form === formName){
                if(eval.name_field === fieldTitle){
                    users.push(eval.value_register);
                }
                filteredEvals.push(eval);
            }
        });
        users = [...new Set(users)];
        users.forEach((user, index)=>{
            filteredEvals.forEach((eval)=>{
                if(eval.name_field === fieldTitle && eval.value_register === user){
                    users[index] = 
                    { 
                        user:user, 
                        id_form:eval.id_form,
                        categories:ProfileModalView._getCategorizedEvals(filteredEvals, eval.id_form, user) 
                    };
                }
            });
        });
        users.forEach((user)=>{
            user.categories.forEach((category)=>{
                category.average=ProfileModalView._getAverage(category.fields);
            });
        });
        ProfileModalView.renderScores(users);
    },
    renderScores:function(users){
        let users_summary = document.getElementById('users_summary');
        let contents = '';
        users.forEach((user)=>{
            if(user.categories[0] === undefined){
                user.categories[0] = { average:0 };
            }
            if(user.categories[1] === undefined){
                user.categories[1] = { average:0 };
            }
            if(user.categories[2] === undefined){
                user.categories[2] = { average:0 };
            }
            contents+=
            `
            <tr>
            <td>${user.user}</td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(255, 217, 102); border-color:rgb(255, 217, 102); color:black; width:150px;">
                    <span class="text">${user.categories[0].average.toFixed(2)*100}%</span>
                </div>
            </td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(106, 168, 79); border-color:rgb(106, 168, 79); width:150px;">
                    <span class="text">${user.categories[1].average.toFixed(2)*100}%</span>
                </div>
            </td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(166, 77, 121); border-color:rgb(166, 77, 121); width:150px;">
                    <span class="text">${user.categories[2].average.toFixed(2)*100}%</span>
                </div>
            </td>`;
            contents+=`
                <td>
                    <button onclick="ProfileModalView.getActionPlan('${user.user}')" data-toggle="modal" data-target="#add_action_plan" type="button" class="btn btn-primary" style="margin:2px; width:130px;"><i class="fas fa-eye"></i> <br>Plan de acción</button>
                </td>`;
            contents+=`</tr>`;

            let summary_container = document.getElementById('summary_container');
            summary_container.style.visibility = 'visible';
        });
        users_summary.innerHTML=contents;
        new DataTable('#users_summary_table');
    },
    getActionPlan:function(email){
        const fields = FiltersUtils.getRegisterFields(email);
        const  highlights_txt = document.getElementById('highlights_txt');
        const  lowlights_txt = document.getElementById('lowlights_txt');
        const fields_txt = document.getElementById('fields_txt');
        let highlight_fields = [];
        let lowlight_fields = [];
        let registers = [];
        let highlight = null;
        let lowlight = null;
        if(fields.length>0){
            fields.forEach((field)=>{
                registers.push(field.id_register);
                if(field.name_field.indexOf('highlight')>=0){
                    highlight = field;
                    highlight_fields.push(field.id_field);
                }
                if(field.name_field.indexOf('lowlight')>=0){
                    lowlight = field;
                    lowlight_fields.push(field.id_field);
                }
            });

            highlights_txt.value = highlight.value_register;
            lowlights_txt.value = lowlight.value_register;

            highlight_fields = [...new Set(highlight_fields)];
            lowlight_fields = [...new Set(lowlight_fields)];
            registers = [...new Set(registers)];
            fields_txt.value = JSON.stringify( { 'registers':registers, 'highlight_fields':highlight_fields, 'lowlight_fields':lowlight_fields } );
        }
    },
    _getAverage:function(fields){
        let counter = 0;
        fields.forEach((field)=>{
            if(field.value_register === 'Si'){
                counter++;
            }
        });
        return counter/fields.length;
    },
    _getCategorizedEvals:function(evals, id_form, user){
        let categories = [];
        evals.forEach((eval)=>{
            if(eval.category != 'uncategorized' && eval.id_form === id_form){
                categories.push(eval.category);
            }
        });
        categories = [...new Set(categories)];
        categories.forEach((category, index)=>{
            categories[index] = 
            { 
                category:category, 
                fields:ProfileModalView._getRegistersByUser(evals, user, category),
                average:0
            };
        });
        return categories;
    },
    _getRegistersByUser:function(evals, user, category){
        let regs = [];
        let fields = [];
        evals.forEach((eval)=>{
            if(eval.value_register === user){
                regs.push(eval.id_register);
            }
        });
        regs = [...new Set(regs)];
        regs.forEach((reg)=>{
            evals.forEach((field)=>{
                if(field.category === category && field.id_register === reg){
                    fields.push({ name_field:field.name_field, value_register:field.value_register });
                }
            });
        });
        return fields;
    }
};