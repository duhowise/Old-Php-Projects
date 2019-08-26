//services
Controller.service("ProfeaResource",function(resource) {
    return resource("http://localhost/AJAX/:operation",
        {operation:"load"},
        {
            loadStatus:{
                method: "GET",
                params: {
                    operation: "notifications_onclick.php"
                }
            },
            postSocket:{
                type: "websocket",
                params:{
                    url:"ws://localhost:1240/sswap/socket/profea_socket",
                    port: 1240,
                    type:"profeaSocket"
                }
            },
            chatSocket:{
               type: "websocket",
               params: {
                   url: "ws://localhost:1250/sswap/socket/chat_socket",
                   port: 1250,
                   type: "chatSocket"
               }
            },
            notiSocket:{
                type: "websocket",
                params: {
                    url: "ws://localhost:1260/sswap/socket/noti_socket",
                    port: 1260,
                    type: "notiSocket"
                }
            },
            refreshStatus:{
                method: "GET",
                repeat: true,
                interval: 12000,
                params: {
                    operation: "notifications_onclick.php"
                }
            }
        }
    );
});