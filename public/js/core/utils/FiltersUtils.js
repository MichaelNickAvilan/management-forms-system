let FiltersUtils = {
    a_users:[],
    a_evaluations:[],
    a_filtered_evaluations:[],
    init:function(users){
        let countries_combo = document.getElementById('countries_combo');
        FiltersUtils.a_users = users;
        countries_combo.innerHTML = FiltersUtils.getUniqueCountries(FiltersUtils.a_users);
        FiltersUtils.addListeners();
        FiltersUtils.countrySelected();
        FiltersUtils.storeSelected();
        FiltersUtils.userSelected();
    },
    addListeners:function(){
        const countries_combo = document.getElementById('countries_combo');
        const stores_combo = document.getElementById('stores_combo');
        const users_combo = document.getElementById('users_combo');
        const dates_combo = document.getElementById('dates_combo');
        const from_date = document.getElementById('from_date');
        const to_date = document.getElementById('to_date');

        countries_combo.addEventListener('change', FiltersUtils.countrySelected);
        stores_combo.addEventListener('change', FiltersUtils.storeSelected);
        users_combo.addEventListener('change', FiltersUtils.userSelected);
        dates_combo.addEventListener('change', FiltersUtils.dateSelected);
        from_date.addEventListener('change', FiltersUtils.fromDateSelected);
        to_date.addEventListener('change', FiltersUtils.toDateSelected);

        if(countries_combo.options.length === 2){
            countries_combo.selectedIndex = 1;
            FiltersUtils.countrySelected( {target:{ value:countries_combo.value }} );
            if(stores_combo.options.length === 2){
                stores_combo.selectedIndex = 1;
                FiltersUtils.storeSelected( {target:{ value:stores_combo.value } } );
            }
        }
    },
    countrySelected:function(e = null){
        const stores_combo = document.getElementById('stores_combo');
        if(e === null){
            stores_combo.innerHTML = FiltersUtils.getStoresByCountry(null);
        }else{
            stores_combo.innerHTML = FiltersUtils.getStoresByCountry(e.target.value);
        }
        FiltersUtils.storeSelected();
        FiltersUtils.filterEvaluations();
    },
    storeSelected:function(e = null){
        const users_combo = document.getElementById('users_combo');
        users_combo.innerHTML = FiltersUtils.getUsersByStoreAndCountry();
        FiltersUtils.filterEvaluations();
    },
    userSelected:function(e = null){
        const dates_combo = document.getElementById('dates_combo');
        dates_combo.selectedIndex = 0;
        FiltersUtils.filterEvaluations();
        dates_combo.innerHTML = FiltersUtils.getDatesByStoreCountryAndUser();
    },
    fromDateSelected:function(e){
        FiltersUtils.filterEvaluations();
    },
    toDateSelected:function(e){
        FiltersUtils.filterEvaluations();
    },
    dateSelected:function(e = null){
        FiltersUtils.filterEvaluations();
    },
    getUniqueCountries:function(users){
        let options = `<option value="">Seleccione un país</option>`;
        let countries = [];
        users.forEach((user) => {
            countries.push(user.country);
        });
        countries = [...new Set(countries)];
        countries.forEach((country)=>{
            options+=`<option value="${country}">${country}</option>`;
        });
        return options;
    },
    getStoresByCountry:function(country){
        let stores = [];
        let options = `<option value="">Seleccione una tienda</option>`;
        FiltersUtils.a_users.forEach((user)=>{
            if(country === null || country === ''){
                stores.push(user.store);
            }else{
                if(user.country === country){
                    stores.push(user.store);
                }
            }
        });
        stores = [...new Set(stores)];
        stores.forEach((store)=>{
            options+=`<option value="${store}">${store}</store>`;
        });
        return options;
    },
    getUsersByStoreAndCountry:function(){
        let users = [];
        let options = `<option value="">Seleccione un usuario</option>`;
        const countries_combo = document.getElementById('countries_combo');
        const stores_combo = document.getElementById('stores_combo');
        FiltersUtils.a_users.forEach((user)=>{
            if(countries_combo.value!='' && stores_combo.value!=''){
                if(user.country === countries_combo.value && user.store === stores_combo.value){
                    users.push(user.email);
                }
            }else{
                if(countries_combo.value != '' && stores_combo.value === ''){
                    if(user.country === countries_combo.value){
                        users.push(user.email);
                    }
                }else{
                    if(countries_combo.value === '' && stores_combo.value != ''){
                        if(user.store === stores_combo.value){
                            users.push(user.email);
                        }
                    }else{
                        if(countries_combo.value === '' && stores_combo.value === ''){
                            users.push(user.email);
                        }
                    }
                }
            }            
        });
        users = [...new Set(users)];
        users.forEach((user)=>{
            options+=`<option value="${user}">${user}</store>`;
        });
        return options;
    },
    getDatesByStoreCountryAndUser:function(){
        let dates = [];
        let options = `<option value="">Seleccione una o varias fechas</option>`;
        FiltersUtils.a_filtered_evaluations.forEach((question)=>{
            dates.push(question.created_at.split(' ')[0]);
        });
        dates = [...new Set(dates)];
        dates.forEach((date)=>{
            options+=`<option value="${date}">${date}</option>`;
        });
        return options;
    },
    filterEvaluations:function(){
        let filtered_evaluations = [];
        let user_centinela = false;
        const countries_combo = document.getElementById('countries_combo');
        const stores_combo = document.getElementById('stores_combo');
        const users_combo = document.getElementById('users_combo');
        const dates_combo = document.getElementById('dates_combo');
        const selected_options = Array.from(dates_combo.selectedOptions);

        ProfileModalView.reset();

        FiltersUtils.a_evaluations.forEach((question)=>{
            if(stores_combo.value!='' || countries_combo.value != '' || users_combo.value != ''){
                if(users_combo.value != ''){
                    user_centinela = true;
                }else{
                    if(stores_combo.value!=''){
                        if(question.store === stores_combo.value){
                            filtered_evaluations.push(question);
                        }
                    }else{
                        if(countries_combo.value != ''){
                            if(question.country === countries_combo.value){
                                filtered_evaluations.push(question);
                            }
                        }
                    }
                }
            }else{
                filtered_evaluations.push(question);
            }
        });

        if(user_centinela === true){
            filtered_evaluations = FiltersUtils.getRegisterFields(users_combo.value);
        }

        let temp_filtered_evaluations = [];

        if(selected_options.length>0){
            filtered_evaluations.forEach((question)=>{
                selected_options.forEach((option)=>{
                    if(question.created_at.indexOf( option.value.split(' ')[0] ) >= 0){
                        temp_filtered_evaluations.push(question);
                    }
                });
            });
            filtered_evaluations = temp_filtered_evaluations;
        }

        if(from_date.value !='' || to_date.value !=''){
            filtered_evaluations = FiltersUtils.filterByDateRange(filtered_evaluations);
        }
        FiltersUtils.a_filtered_evaluations = filtered_evaluations;
        UserProfile.init( filtered_evaluations );
    },
    filterByDateRange:function(registers){
        let centinel = true;
        let filtered_regs = [];
        const from_date = document.getElementById('from_date');
        const to_date = document.getElementById('to_date');

        registers.forEach((reg)=>{
            if(from_date.value != '' || to_date.value != ''){
                
                const from = new Date(from_date.value);
                const to = new Date(to_date.value);
                const reg_date = new Date(reg.created_at);

                if(from_date.value != '' && to_date.value != ''){
                    if(reg_date >= from && reg_date <= to){
                        filtered_regs.push(reg);
                    }
                }else{
                    if(from_date.value != ''){
                        if(reg_date >= from){
                            filtered_regs.push(reg);
                        }
                    }else{
                        if(to_date.value != ''){
                            if(reg_date <= to){
                                filtered_regs.push(reg);
                            }
                        }
                    }
                }
            }
            
        });
        return filtered_regs;
    },
    getRegisterFields:function(email, returnIds = false){
        let registers = [];
        let items = [];
        FiltersUtils.a_evaluations.forEach((question)=>{
            if(question.value_register === email){
                registers.push(question.id_register);
            }
        });
        registers = [...new Set(registers)];
        if(returnIds === true){
            return registers;    
        }else{
            FiltersUtils.a_evaluations.forEach((question)=>{
                registers.forEach((reg)=>{
                    if(question.id_register === reg){
                        items.push(question);
                    }
                });
            });
            return items;
        }
    }
};