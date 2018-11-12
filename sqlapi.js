var request = require('request')
const rp = require('request-promise')
const express = require('express')
const app = express()
const mysql = require('mysql');

const connection = mysql.createConnection({
    host: 'circuitos.cr0c2d7y40q0.us-east-1.rds.amazonaws.com',
    port: 3306,
    user: 'root',
    password: 'root1234',
    database: 'progra'
  })

  app.get("/:id", (req, res) => {
    const id = req.params.id
    Date.prototype.format=function(fstr,utc){
        var that =this;
        utc=utc ? 'getUTC':'get';
        return fstr.replace(/%[YmdHMS]/g,function(m){
            switch(m){
                case '%Y':return that[utc+'FullYear']();
                case '%m':m=1+that[utc+'Month']();break;
                case '%d':m=that[utc+'Date']();break;
                default :return m.slice(2);

            }
            return(''+m).slice(-2);
        })

    }
    a=new Date();
    fecha=a.format("%Y-%m-%d,true");
    var values="";
    console.log(id);
    /*var arr = id.split(",")
    values+="("+arr[0]+",'2018-10-29')"
    if (arr.length>1){
        for (var i=1;i<arr.length;i++){
            values+=",("+arr[i]+",'2018-10-29')"
        }
    }
    console.log(values); */  
    const queryString = "INSERT INTO reg_temp (id_vaca, fecha_registro) VALUE ("+"'"+id+"'"+","+"'"+fecha+"'"+")";
    connection.query(queryString, function (err, result) {
        if (err) throw err;
      });
      
  })
    
  app.listen(3003, () => {
    console.log("Server is up and listening on 3003...")
  })
