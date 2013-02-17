(function($){
    $('document').ready(function(){
        $('#count_pages').click(function(){
            var categories = getCategories();
            $('#status').text('Количество категорий:'+categories.length);
            var i = 0;
            setInterval(function(){
                getCountPages(categories[i]['src'], categories[i]['parent_src']);
                i++;
                $('#status').text('Осталось обработать:'+(categories.length - i));
            }, 10000);
        });
        
        $('#pre_product').click(function(){
            var categories = getCategories();
            //console.log(categories);
            
            $('#status').text('Количество категорий:'+categories.length);
            var i = 0;
            setInterval(function(){
                var page = 1;
                var count_pages = categories[i]['count_pages'];
                $('#status-2').text("Количество страниц:"+count_pages);
                if(count_pages!=0)
                {
                    setInterval(function(){
                        if(page<count_pages)
                        {
                            getItems(categories[i]['category_id'], categories[i]['src'], categories[i]['parent_src'], page);
                            page++;
                            $('#status-2').text("Количество страниц осталось обработать:"+(count_pages-page));
                        }
                    }, 3000)
                }
                
                i++;
                $('#status').text('Осталось обработать:'+(categories.length - i));
            }, 180000);
        });
    });
})(jQuery)

function getCountPages(category, parent)
{
    $.ajax({
            url:'http://query.yahooapis.com/v1/public/yql',
            dataType:'jsonp',
            data:{
                    q:'use "http://212.22.194.77/hotline/pages.xml" as quotes; select * from quotes where category=\''+category+'\' AND parent=\''+parent+'\';',
                    format:'json'
            },
            success:function(data){
                    console.log(category);
                    var pages = data.query.results.html.body.p;
                    var reg = new RegExp(/[0-9]*?$/);
                    var count_pages = reg.exec(pages)[0];
                    
                    
                    $.ajax({
                        url:'index.php',
                        async:false,
                        data:{
                            r:'category/updateCountPages',
                            category:category,
                            parent:parent,
                            count_pages:count_pages
                        },
                        success:function(data){
                            console.log(data);
                        },
                        error:function(data){
                            console.log(data);
                        }
                    }
                    );
            },
            error:function(data){
                    console.log(data);
            }
    });    
}

function getItems(category_id, category, parent, page)
{
        $.ajax({
                url:'http://query.yahooapis.com/v1/public/yql',
                dataType:'jsonp',
                data:{
                        q:'use "http://212.22.194.77/hotline/hotline.xml" as quotes; select * from quotes where category=\''+category+'\' and page=\''+page+'\' and parent=\''+parent+'\';',
                        format:'json'
                },
                success:function(data){
                        var href = '';
                        var name = '';
                        var desc = '';
                        var thumb = '';
                        var price = '';
                        try
                        {
                            for(var i = 0; i<data.query.results.html.body.ul.li.length; i++)
                            {
                                    href = data.query.results.html.body.ul.li[i].div[2].div[0].h3.a.href;
                                    name = data.query.results.html.body.ul.li[i].div[2].div[0].h3.a.content;
                                    desc = data.query.results.html.body.ul.li[i].div[2].p;
                                    thumb = data.query.results.html.body.ul.li[i].div[1].div != undefined?data.query.results.html.body.ul.li[i].div[1].div.img.src:data.query.results.html.body.ul.li[i].div[1].img.src;
                                    price = data.query.results.html.body.ul.li[i].div[0].span.content;
                                    $.ajax({
                                        url:'index.php',
                                        type:'POST',
                                        async:false,
                                        data:{
                                            r:'parser/save',
                                            category_id:category_id,
                                            name:name,
                                            intro_desc:desc,
                                            desc:desc,
                                            current_price:price,
                                            images:'',
                                            main_image:'',
                                            thumb_image:thumb,
                                            path:href
                                        },
                                        success:function(data){
                                            console.log(data);
                                        },
                                        error:function(data){
                                            console.log(data);
                                        }
                                    });
                            }
                        }catch(err){
                            var log = new Object();
                            log.q = 'use "http://212.22.194.77/hotline/hotline.xml" as quotes; select * from quotes where category=\''+category+'\' and page=\''+page+'\' and parent=\''+parent+'\';';
                            log.error = err.message;
                            setLog(log);                 
                        }
                },
                error:function(data){
                        console.log(data);
                }
        });
}

function getItem(path)
{
        $.ajax({
                url:'http://query.yahooapis.com/v1/public/yql',
                dataType:'jsonp',
                data:{
                        q:'use "http://212.22.194.77/hotline/part.xml" as quotes; select * from quotes where path=\''+path+'\';',
                        format:'json'
                },
                success:function(data){
                        var property = '';
                        var value = '';
                        
                        for(var i = 0; i<data.query.results.html.body.table.tr.length; i++)
                        {
                                if(data.query.results.html.body.table.tr[i].td !== undefined&&data.query.results.html.body.table.tr[i].td.length>1)
                                {
                                    property 	= data.query.results.html.body.table.tr[i].td[0].p;
                                    value 		= data.query.results.html.body.table.tr[i].td[1].p;
                                    $.ajax({
                                        url:'index.php',
                                        type:'POST',
                                        async:false,
                                        data:{
                                            r:'parser/saveitem',
                                            feature_name:property,
                                            feature_value:value,
                                            path:path
                                        },
                                        success:function(data){
                                            console.log(data);
                                        },
                                        error:function(data){
                                            console.log(data);
                                        }
                                    });
                                }
                        }
                },
                error:function(data){
                        console.log(data);
                }
        });
        return false;
}

function getCategories()
{   
    var ret;
    $.ajax({
        url:'index.php',
        dataType:'json',
        async:false,
        data:{
            r:'category/list'
        },
        success:function(data){
            ret = data;
        }
    });
    return ret;
}

function setAuction()
{
    $.ajax({
        url:'index.php',
        type:'POST',
        data:{
            r:'user/newauction'
        }
    });
}

function setLog(data)
{
    $.ajax({
        url:'index.php',
        type:'POST',
        data:{
            r:'parser/log',
            data:data
        },
        success:function(data){
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    });
}