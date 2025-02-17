var DataTablesUtils={
    init:function(id, _paging=true, _order = [0, 'desc'], panes=[]){
        let columns = $('#'+id)[0].children[0].children[0].children.length;
        let indexes = [];
        if(panes != []){
            indexes = DataTablesUtils._getIndexes(columns);
        }else{
            indexes = panes;
        }
        let table = $('#'+id).DataTable({
            order: _order,
            paging: false,
            ordering:false,
            searching:true
        });
        if(document.location.pathname === '/registers'){
            DataTablesUtils.defineCharts(table);
        }
        table.on('draw', function() {
            if(document.location.pathname === '/registers'){
                DataTablesUtils.defineCharts(table);
            }
        });
    },
    _getIndexes:function(columns){
        let indexes = [];
        for(let i=1;i<columns-4;i++){
            indexes.push(i);
        }
        return indexes;
    },
    defineCharts:function(table){
        let _titles = [];
        let titles = Array.from(table.columns().titles());
        titles = DataTablesUtils._getValidTitles(titles);
        titles.forEach((title)=>{
            _titles.push(
                {
                    title:title.title,
                    index:title.index,
                    answers: []
                }
            );
        });
        return DataTablesUtils._getStackedChart( DataTablesUtils._getFormattedAnswers(table, _titles), _titles );
    },
    _getStackedChart:function(series, titles){
        let _titles = [];
        titles.forEach((title)=>{
            _titles.push(title.title);
        });
        let definition = {
            chart: {
                type: 'column'
            },
        
            title: {
                text: ''
            },
        
            xAxis: {
                categories: _titles
            },
        
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: ''
                }
            },
        
            tooltip: {
                format: '<b>{key}</b><br/>{series.name}: {y}<br/>' +
                    'Total: {point.stackTotal}'
            },
        
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
        
            series: series
        };
        Highcharts.chart('stacked_container', definition);
    },
    _getFormattedAnswers:function(table, titles){
        titles.forEach((title, t_index)=>{
            table.rows({"search":"applied" }).every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                data.forEach((column, index)=>{
                    if(title.index === index){
                        titles[t_index].answers.push(column);
                    }
                });
            });
        });
        return DataTablesUtils._getSeries(titles);
    },
    _getSeries:function(titles){
        console.log(titles);
        let series_columns = ['Si', 'No'];
        series_columns.forEach((serie, serie_index)=>{
            series_columns[serie_index] = { name:serie, data:[], stack:'' };
            titles.forEach((title, t_index)=>{
                series_columns[serie_index].data.push(
                    DataTablesUtils._countCoincidences(serie, title.answers)
                );
            });
        });

        console.log(series_columns);

        series_columns.forEach((serie, index)=>{
            switch(serie.name){
                case 'Si':
                    serie['color'] = 'green';
                break;
                case 'No':
                    serie['color'] = 'red';
                break;
                default:
                    serie['color'] = 'yellow';
            }
            series_columns[index] = serie;
        });
        return series_columns;
    },
    _countCoincidences:function(value, answers){
        let count = 0;
        answers.forEach((answer)=>{
            if(answer === value){
                count++;
            }
        });
        return count;
    },
    _renderContainers:function(titles){
        let charts_container = document.getElementById('charts_container');
        titles.forEach((title)=>{
            const template = document.createElement('div');
            template.innerHTML =
            `<div class="card col-lg-4 shadow mb-4" style="float:left;">
                        <div class="btn btn-primary btn-user btn-block"> ${title.title} </div>
                        <div id="${title.index}_chart" style="width:100%; height:400px;"></div>
                    </div>
             `;
            charts_container.append(template.children[0]);
        });
    },
    _getValidTitles:function(titles){
        const urlParams = new URLSearchParams(window.location.search);
        let _titles = [];
        titles.forEach((title, index)=>{
            if(urlParams.get('id_form')>=83){
                if( index >4 && index < (titles.length-5) ){
                    _titles.push({ title: title, index:index });
                }    
            }else{
                if( index >4 && index < (titles.length-4) ){
                    _titles.push({ title: title, index:index });
                }
            }
            
        });
        return _titles;
    }
    
};