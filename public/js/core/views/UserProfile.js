let UserProfile = {
    a_geo_data:[],
    a_evaluations:[],
    a_processed_rows:[],
    a_registers:[],
    a_answers:[],
    a_current_user:null,
    init:function(  evaluations ){
        UserProfile.a_evaluations = evaluations;
        UserProfile.formatEvaluations();
        UserProfile.calculateTopAndBottomPerformers();
    },
    confirmCommitment:function(url){
        Swal.fire({
            title: "<strong>Vas camino al <u>éxito!</u></strong>",
            icon: "info",
            html: `
              Al firmar un <b>compromiso</b> estás dando un paso más,
              para mejorar tu desempeño.
            `,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `
              <a href="${url}" style="color:white !important;"><i class="fa fa-thumbs-up"></i> Firmar compromiso!</a>
            `,
            confirmButtonAriaLabel: "Thumbs up, great!",
            cancelButtonText: `
              <i class="fa fa-thumbs-down"></i> No firmar aún
            `,
            cancelButtonAriaLabel: "Cancelar"
          });
    },
    navigateToRegisters:function(url){
        document.location.href=url;
    },
    formatEvaluations:function(){
        let _forms = UserProfile._getUniqueValues(UserProfile.a_evaluations, 'id_form');
        let forms = [];
        _forms.forEach((id)=>{
            if(UserProfile._getFormName(id) != 'Compromisos'){
                let form = 
                { 
                    form_id:id, 
                    form_name:UserProfile._getFormName(id), 
                    evals:UserProfile._getEvaluations(id)
                };
                form.evals = UserProfile._getCategories(form.evals);
                forms.push(form);
            }
        });
        UserProfile.renderRows(forms);
    },
    calculatePercentage:function(num, total){
        if(total === 0){
            return 0;
        }else{
            return num/total;
        }
    },
    countAnswers:function(arr, ans){
        let counter = 0;
        arr.forEach((item)=>{
            if(item.value_register === ans){
                counter++;
            }
        });
        return counter;
    },
    updateBar:function(id, percentage, total, _label='evaluaciones', _complement='%'){
        let bar = document.getElementById(id);
        let label = document.getElementById(id+'_label');
        bar.style.width = percentage+_complement;
        label.innerHTML = percentage.toFixed(0)+_complement + ' de '+ total + ' ' + _label;
    },
    renderRows:function(items){
        let rows = [];
        items.forEach((item)=>{
            let row = { form_id:item.form_id, form_name:item.form_name, connect:0, engage:0, inspire:0 }
            item.evals.forEach((eval)=>{
                row.connect+= eval.categories.connect.score;
                row.engage+= eval.categories.engage.score;
                row.inspire+= eval.categories.inspire.score;
            });
            row.connect = row.connect / item.evals.length;
            row.engage = row.engage / item.evals.length;
            row.inspire = row.inspire / item.evals.length;
            rows.push(row);
        });
        let container = document.getElementById('profile_table_body');
        let html = ``
        rows.forEach((_row)=>{
            html+=`
            <tr>
            <td>${_row.form_name}</td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(255, 217, 102); border-color:rgb(255, 217, 102); color:black; width:150px;">
                    <span class="text">${(_row.connect * 100).toFixed(2)}%</span>
                </div>
            </td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(106, 168, 79); border-color:rgb(106, 168, 79); width:150px;">
                    <span class="text">${(_row.engage * 100).toFixed(2)}%</span>
                </div>
            </td>
            <td>
                <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:rgb(166, 77, 121); border-color:rgb(166, 77, 121); width:150px;">
                    <span class="text">${(_row.inspire * 100).toFixed(2)}%</span>
                </div>
            </td>`;
            if(UserProfile.a_current_user!='empty'){
                if(UserProfile.isSigned(_row.form_name)){
                    let profile_url = `/registers?id_form=${_row.form_id}&email=${UserProfile.a_current_user.email}&user_id=${UserProfile.a_current_user.id}`;
                    html+=
                    `<td>
                        <div class="btn btn-warning btn-icon-split btn-sm" style="background-color:#efefef; border-color:#efefef; width:150px; color:black;">
                            <span class="text">Compromiso firmado</span>
                        </div>
                        <button onclick="UserProfile.navigateToRegisters('${profile_url}')" type="button" class="btn btn-primary"><i class="fas fa-address-card"></i> Ver evaluaciones</button>
                        <button onclick="ProfileModalView.init('${_row.form_name}')" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary"><i class="fas fa-info"></i> Ver detalle</button>
                    </td>
                    </tr>
                    `;
                }else{
                    let profile_url = `/registers?id_form=${_row.form_id}&email=${UserProfile.a_current_user.email}&user_id=${UserProfile.a_current_user.id}`;
                    let url =`/registers/create?id_user=${UserProfile.a_current_user.id}&system=14&form=95&email=${UserProfile.a_current_user.email}&form_name=${_row.form_name}&connect=${_row.connect}&engage=${_row.engage}&inspire=${_row.inspire}&type=auto`; 
                    html+=
                    `<td>
                        <button onclick="UserProfile.confirmCommitment('${url}')" type="button" class="btn btn-primary" style="margin:2px; width:100px;"><i class="fas fa-info-circle"></i> Compromiso</button>
                        <button onclick="UserProfile.navigateToRegisters('${profile_url}')" type="button" class="btn btn-primary" style="margin:2px; width:100px;"><i class="fas fa-address-card"></i> Evaluaciones</button>
                        <button onclick="ProfileModalView.init('${_row.form_name}')" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary" style="margin:2px; width:100px;"><i class="fas fa-info"></i> <br/>Detalle</button>
                    </td>
                    </tr>
                    `;
                }
            }else{
                let profile_url = `/registers?id_form=${_row.form_id}`;
                html+=`<td><button onclick="UserProfile.navigateToRegisters('${profile_url}')" type="button" class="btn btn-primary" style="margin:2px; width:100px;"><i class="fas fa-address-card"></i> Evaluaciones</button>
                <button onclick="ProfileModalView.init('${_row.form_name}')" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-primary" style="margin:2px; width:100px;"><i class="fas fa-info"></i> </br>Detalle</button>
                </tr>
                `;
            }
        });
        container.innerHTML = html;
        let table = new DataTable('#regs_table');
        UserProfile.renderKPIs(rows);
        if(rows.length === 1){
            ProfileModalView.init( rows[0].form_name );
        }
    },
    calculateTopAndBottomPerformers:function(){
        let answers = { affirmative:[], negative:[] };
        UserProfile.a_evaluations.forEach((item)=>{
            switch(item.value_register){
                case 'Si':
                    answers.affirmative.push(item.name_field);
                break;
                case 'No':
                    answers.negative.push(item.name_field);
                break;
            }
        });
        answers.affirmative = UserProfile._getRepetitions(answers.affirmative);
        answers.negative = UserProfile._getRepetitions(answers.negative);
        answers.affirmative = UserProfile._getOrderedList(answers.affirmative);
        answers.negative = UserProfile._getOrderedList(answers.negative);

        answers.affirmative.forEach((affirmative_item, aIndex)=>{
            answers.negative.forEach((negative_item, nIndex)=>{
                if(affirmative_item.key === negative_item.key){
                    let total = affirmative_item.val + negative_item.val;
                    answers.affirmative[aIndex]['total'] = total;
                    answers.negative[nIndex]['total'] = total;
                    answers.affirmative[aIndex]['percentage'] = answers.affirmative[aIndex].val / total;
                    answers.negative[nIndex]['percentage'] = answers.negative[nIndex].val / total;
                }

            });
        });

        if(answers.affirmative.length>0 ){
            UserProfile._updateBar('top_bar_yes', answers.affirmative[0].percentage*100 , answers.affirmative[0].key + ': ' + answers.affirmative[0].val+' respuestas');
            UserProfile._updateBar('high_bar_yes', answers.affirmative[1].percentage*100, answers.affirmative[1].key + ': ' + answers.affirmative[1].val+' respuestas');
            UserProfile._updateBar('middle_bar_yes', answers.affirmative[2].percentage*100, answers.affirmative[2].key + ': ' + answers.affirmative[2].val+' respuestas');
            UserProfile._updateBar('low_bar_yes', answers.affirmative[3].percentage*100, answers.affirmative[3].key + ': ' + answers.affirmative[3].val+' respuestas');
            UserProfile._updateBar('bottom_bar_yes', answers.affirmative[4].percentage*100, answers.affirmative[4].key + ': ' + answers.affirmative[4].val+' respuestas');
        }else{
            UserProfile._updateBar('top_bar_yes', 0 , ' sin respuestas');
            UserProfile._updateBar('high_bar_yes', 0, ' sin respuestas');
            UserProfile._updateBar('middle_bar_yes', 0, ' sin respuestas');
            UserProfile._updateBar('low_bar_yes', 0, ' sin respuestas');
            UserProfile._updateBar('bottom_bar_yes', 0, ' sin respuestas');
        }
        if(answers.negative.length>0 ){
            UserProfile._updateBar('top_bar_no', answers.negative[0].percentage*100, answers.negative[0].key + ': ' + answers.negative[0].val+' respuestas');
            UserProfile._updateBar('high_bar_no', answers.negative[1].percentage*100, answers.negative[1].key + ': ' + answers.negative[1].val+' respuestas');
            UserProfile._updateBar('middle_bar_no', answers.negative[2].percentage*100, answers.negative[2].key + ': ' + answers.negative[2].val+' respuestas');
            UserProfile._updateBar('low_bar_no', answers.negative[3].percentage*100, answers.negative[3].key + ': ' + answers.negative[3].val+' respuestas');
            UserProfile._updateBar('bottom_bar_no', answers.negative[4].percentage*100, answers.negative[4].key + ': ' + answers.negative[4].val+' respuestas');
        }else{
            UserProfile._updateBar('top_bar_no', 0 , ' sin respuestas');
            UserProfile._updateBar('high_bar_no', 0, ' sin respuestas');
            UserProfile._updateBar('middle_bar_no', 0, ' sin respuestas');
            UserProfile._updateBar('low_bar_no', 0, ' sin respuestas');
            UserProfile._updateBar('bottom_bar_no', 0, ' sin respuestas');
        }
    },
    _updateBar:function(id, percentage, _label){
        let bar = document.getElementById(id);
        let label = document.getElementById(id+'_label');
        bar.style.width = percentage+'%';
        label.innerHTML = _label + '. ';
    },
    _getOrderedList:function(arr){
        let values = (Object.values(arr));
        let keys = Object.keys(arr);
        let items = [];
        let deduplicated = [];
        values = [...new Set(values)];
        values = (values.sort((a,b) => b - a));
        values.length = 5;
        
        values.forEach((val)=>{
            keys.forEach((key)=>{
                if(arr[key] === val){
                    items.push({ key:key, val:val, total:val, percentage:1});
                }
            });
        });

        values.forEach((val,index)=>{
            deduplicated.push( items[index] );
        });
        return items;
    },
    _getRepetitions:function(arr){
        const counter = {};
        arr.forEach(ele => {
            if (counter[ele]) {
                counter[ele] += 1;
            } else {
                counter[ele] = 1;
            }
        });
        return counter;
    },
    renderKPIs:function(rows){
        UserProfile.a_processed_rows = rows;
        let kpis = { mood:0, connect:0, engage:0, inspire:0 };
        rows.forEach((row)=>{
            kpis.connect += Number(row.connect);
            kpis.engage += Number(row.engage);
            kpis.inspire += Number(row.inspire);
        });

        let mood_container = document.getElementById('mood_container');
        let connect_container = document.getElementById('connect_container');
        let engage_container = document.getElementById('engage_container');
        let inspire_container = document.getElementById('inspire_container');

        let mood_bar = document.getElementById('mood_bar');
        let connect_bar = document.getElementById('connect_bar');
        let engage_bar = document.getElementById('engage_bar');
        let inspire_bar = document.getElementById('inspire_bar');

        kpis = { 
            mood:0, 
            connect:(kpis.connect / rows.length), 
            engage:(kpis.engage / rows.length), 
            inspire:(kpis.inspire / rows.length) 
        };
        kpis.mood = (kpis.engage + kpis.connect + kpis.inspire) / 3;

        kpis.mood =  String(parseInt(kpis.mood.toFixed(2)*100));
        kpis.engage = String(parseInt(kpis.engage.toFixed(2)*100)) +'%';
        kpis.connect = String(parseInt(kpis.connect.toFixed(2)*100))+'%';
        kpis.inspire = String(parseInt(kpis.inspire.toFixed(2)*100))+'%';
        
        if(kpis.engage.indexOf('NaN')>=0){
            kpis.connect = '0%';
        }
        if(kpis.engage.indexOf('NaN')>=0){
            kpis.engage = '0%';
        }
        if(kpis.inspire.indexOf('NaN')>=0){
            kpis.inspire = '0%';
        }
        if(kpis.mood.indexOf('NaN')>=0){
            kpis.mood = 0;
        }
        
        connect_container.innerText = kpis.connect;
        engage_container.innerText = kpis.engage;
        inspire_container.innerText = kpis.inspire;
        mood_container.innerText = kpis.mood + '%';

        connect_bar.style.width = kpis.connect;
        engage_bar.style.width = kpis.engage;
        inspire_bar.style.width = kpis.inspire;
        mood_bar.style.width = kpis.mood+'%';

        let mood = kpis.mood / 100;
        let mood_face = document.getElementById('mood_face');

        if(mood >= 0 && mood<=0.2){
            mood_bar.style.cssText +='background-color: red !important';
            mood_face.setAttribute('class', 'far fa-angry fa-4x text-gray-300');
        }
        if(mood>0.2 && mood<=0.4){
            mood_bar.style.cssText +='background-color: red !important';
            mood_face.setAttribute('class', 'far fa-frown fa-4x text-gray-300');
        }
        if(mood>0.4 && mood<=0.6){
            mood_bar.style.cssText +='background-color: yellow !important';
            mood_face.setAttribute('class', 'far fa-flushed fa-4x text-gray-300');
        }
        if(mood>0.6 && mood<=0.8){
            mood_bar.style.cssText +='background-color: yellow !important';
            mood_face.setAttribute('class', 'far fa-smile fa-4x text-gray-300');
        }
        if(mood>0.8 && mood<=1){
            mood_bar.style.cssText +='background-color: green !important';
            mood_face.setAttribute('class', 'far fa-grin-alt fa-4x text-gray-300');
        }
        
    },
    isSigned:function(form_name){
        let validate = false;
        UserProfile.a_evaluations.forEach((eval)=>{
            if(eval.name_form === 'Compromisos'){
                if(eval.value_register === form_name){
                    validate = true;
                }
            }
        });
        return validate;
    },
    _getCategories:function(evals){
        let items = [];
        evals.forEach((eval)=>{
            let item = { id_register: eval.id_register, categories:{ connect:{ fields:[], score:0 }, engage:{ fields:[], score:0 }, inspire:{ fields:[], score:0 }, uncategorized:{ fields:[], score:0 }, mood:{ score:0 } } }
            eval.fields.forEach((field)=>{
                switch(field.category){
                    case 'connect':
                        item.categories.connect.fields.push(field);
                    break;
                    case 'engage':
                        item.categories.engage.fields.push(field);
                    break;
                    case 'inspire':
                        item.categories.inspire.fields.push(field);
                    break;
                }
            });
            items.push(item);
        });
        items.forEach((item, index)=>{
            items[index].categories.connect.score = UserProfile._getScore(item.categories.connect.fields);
            items[index].categories.engage.score = UserProfile._getScore(item.categories.engage.fields);
            items[index].categories.inspire.score = UserProfile._getScore(item.categories.inspire.fields);
            items[index].categories.mood.score = ((Number(item.categories.connect.score) + Number(item.categories.engage.score) + Number(item.categories.inspire.score)) / 3).toFixed(2);
            UserProfile.a_registers.push(items[index]);
        });
        return items;
    },
    _getScore:function(fields){
        const total = fields.length;
        let counter = 0;
        
        fields.forEach((field)=>{
            if(field.value_register.toUpperCase() === 'SI'){
                counter = counter +1;
            }
        });

        let calculation = (( counter / total ));
        if(total === 0){
            calculation = 0;
        }
        return calculation;
    },
    _getEvaluations:function(id){
        let evals = [];
        let items = [];
        UserProfile.a_evaluations.forEach((eval)=>{
            if(eval.id_form == id){
                evals.push(eval.id_register);
            }
        });
        evals = [...new Set(evals)];
        evals.forEach((eval_id)=>{
            let item = {
                id_register: eval_id,
                fields:[]
            };
            UserProfile.a_evaluations.forEach((_eval)=>{
                if(_eval.id_register == item.id_register ){
                    item.fields.push(_eval);
                }
            });
            items.push(item);
        });
        return items;
    },
    _getFormName:function(id){
        let form_name = '';
        UserProfile.a_evaluations.forEach((eval)=>{
            if(eval.id_form == id){
                form_name = eval.name_form;
            }
        });
        return form_name;
    },
    _getUniqueValues:function(arr, prop){
        let items = [];
        arr.forEach((item)=>{
            items.push(item[prop]);
        });
        items = [...new Set(items)];
        return items;
    }
};