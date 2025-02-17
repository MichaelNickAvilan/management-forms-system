let ReportBuilder = {
    a_table:null,
    a_headers:[],
    init:function(){
        ReportBuilder.a_table = document.getElementById('regs_table');
        ReportBuilder.a_headers = ReportBuilder.getHeaders();
        console.log( ReportBuilder.getRows() );
    },
    getHeaders:function(){
        let attributes = [];
        let headers = Array.from(ReportBuilder.a_table.children[1].children[0].children);
        headers.forEach((item, index)=>{
            if(index<headers.length-1){
                attributes.push(item.textContent);
            }
        });
        return attributes;
    },
    getRows:function(){
        let users = ReportBuilder.getOrderedUSers();
        let _users = [];
        users.forEach((item, index)=>{
            let results = ReportBuilder.getResults(item.user);
            if(results.length>0){
             users[index].results = ReportBuilder.getResults(item.user);   
             _users.push(users[index]);
            }else{
                users.splice(index, 1);
            }
        });
        console.log(_users);
        let ev_columns = ReportBuilder.getColumnsToEvaluate(ReportBuilder.a_headers, _users[0].results[0]);
        let evaluations = ReportBuilder.computeEvaluations(_users, ev_columns);
        ReportBuilder.compileCSV(evaluations);
    },
    compileCSV:function(evaluations){
        let rows = '';
        rows += ReportBuilder.a_headers.join(';')+'\n';
        evaluations.forEach((ev)=>{
            ReportBuilder.a_headers.forEach((header, index)=>{
                if(index<ReportBuilder.a_headers.length-1){
                    rows+=ev[header]+';'
                }else{
                    rows+=ev[header]+'\n';
                }
            });
        });
        ReportBuilder.downloadFile(rows);
    },
    downloadFile:function(csv){
        const blob = new Blob([csv], { type:'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('href', url);
        a.setAttribute('download', 'report.csv')
        a.click();
    },
    computeEvaluations:function(users, evaluationColumns){
        let evaluations = [];
        users.forEach((user)=>{
            let frame = ReportBuilder.getResultFrame();
            user.results.forEach((result)=>{
                evaluationColumns.forEach((evColumn)=>{
                    if(result[evColumn] === 'Si'){
                        frame[evColumn] ++;
                    }
                });
                evaluations.push(result);
            });
            user.results.push(frame);
            evaluations.push(frame);
        });
        return evaluations;
    },
    getResults:function(user){
        let objs = [];
        let rows = Array.from(ReportBuilder.a_table.children[2].children);
        rows.forEach((row)=>{
            let _columns = Array.from(row.children);
            let _name = _columns[4].innerText;
            if(_name.indexOf(user)>=0){
                let obj = ReportBuilder.getResultFrame(_columns);
                objs.push(obj);
            }
        });
        return objs;
    },
    getColumnsToEvaluate:function(headers, obj){
        let _headers = [];
        headers.forEach((head)=>{
            if( obj[head]==='Si' || obj[head]==='No' || obj[head]==='Pendiente por diligenciar'){
                _headers.push(head);
            }
        });
        return _headers;
    },
    getResultFrame:function(column=null){
        let obj = {};
        ReportBuilder.a_headers.forEach((header, index)=>{
            if(column!=null){
                obj[header] = column[index].textContent;
            }else{
                obj[header] = 0;
            }
        });
        return obj;
    },
    getOrderedUSers:function(){
        let objs = [];
        let users = [];
        let rows = Array.from(ReportBuilder.a_table.children[2].children);
        rows.forEach((row)=>{
            let label = row.children[4].textContent;
            users.push( ReportBuilder.getCleanedUser(label) );
        });
        users =  [...new Set(users)];
        users.forEach((_user)=>{
            let obj = { user: _user, results:[]};
            objs.push(obj);
        });
        return objs;
    },
    getCleanedUser:function(label){
        let _label = (label.split(' '));
        if(_label.length>3){
            label = _label[1]  + ' ' + _label[2]; 
        }
        return label;
    }
};