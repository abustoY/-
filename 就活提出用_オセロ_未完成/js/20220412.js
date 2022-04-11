let cellstate = new Array();

for (let i=1;i<=8;i+=1){
    cellstate[i] = new Array();
}
cellstate[0] = new Array();
cellstate[9] = new Array();
// 後ほどcellstate[0]とcellstate[9]を参照するため、エラー対策に設定
console.log("cellstate[9][5]"+" "+cellstate[9][5]);
console.log("cellstate[5][9]"+" "+cellstate[5][9]);

for (let i=1;i<=8;i+=1){
    for (let j=1;j<=8;j+=1){
        cellstate[i][j]=0;
    }
}
cellstate[4][4] = 100;
cellstate[4][5] = -100;
cellstate[5][4] = -100;
cellstate[5][5] = 100;

let turn=1;
let judge_turn=0;
color=["白","","黒"];

let judge_pass=0;
let continuous_pass=0;


makeboard();
setrock();


function makeboard(){
    let board_part1="<tr><td colspan='6'>"+"オセロ"+"</td><td colspan='2'>"+"<button onClick='passTurn()'>"+"パス"+"</button>"+"</td></tr>"+"<tr><td colspan='8'>"+color[turn+1]+"の番です"+"</td></tr>";
    let board_part2="";
    for(let i=1;i<=8;i++){
        let row_cells="";
        for(let j=1;j<=8;j++){
            row_cells += `<td id=${i}${j} onclick='clicked(this);' width='40' height='40' bgcolor='#669966'></td>`;
        }
        board_part2+="<tr>"+row_cells+"</tr>";
    }
    let board=board_part1+board_part2;
    document.getElementById("product_board").innerHTML=board;
}


function setrock(){
    for(let i=1;i<=8;i+=1){
        for(let j=1;j<=8;j+=1){
            if(cellstate[i][j]==100){
                document.getElementById(`${i}${j}`).textContent="●";
                document.getElementById(`${i}${j}`).style.color="black";
                document.getElementById(`${i}${j}`).style.fontSize="25px";
            }
            if(cellstate[i][j]==-100){
                document.getElementById(`${i}${j}`).textContent="●";
                document.getElementById(`${i}${j}`).style.color="white";
                document.getElementById(`${i}${j}`).style.fontSize="25px";
            }

        }
    }

}


function clicked(argument){
    let vercellnum=parseInt(Number(argument.id)/10);
    // parseIntは引数を整数値に変える
    console.log("vercellnum"+" "+vercellnum);
    let horcellnum=Number(argument.id)-10*parseInt(Number(argument.id)/10);
    console.log("horcellnum"+" "+horcellnum);

    if(cellstate[vercellnum][horcellnum]==0){
        let count_canput_around=0;
        let count_canput_sand=0;
        // 石を置けない理由を表示するための変数

        for(let i=-1;i<=1;i+=1){
            for(let j=-1;j<=1;j+=1){
                let dashy=vercellnum+i;
                let dashx=horcellnum+j;

                // 前提として選択したセルの8方隣どれかに反対の色の石がないと、選択したセルに置けない
                if(cellstate[dashy][dashx]==turn*100*(-1)){
                    count_canput_around+=1;

                    while(cellstate[dashy][dashx]==turn*100*(-1) && dashx>=1 && dashx<=8 && dashy>=1 && dashy<=8){
                        dashx+=j;
                        dashy+=i;
                    }
                    
                    if(cellstate[dashy][dashx]==turn*100){
                        count_canput_sand+=1;

                        cellstate[vercellnum][horcellnum]=turn*100;
                        let pox=horcellnum+j;
                        let poy=vercellnum+i;
                        while(pox!=dashx || poy!=dashy){
                            cellstate[poy][pox]=turn*100;
                            pox+=j;
                            poy+=i;
                            console.log("while");
                            console.log(`dashx:${dashx} dashy:${dashy} pox:${pox} poy:${poy} j:${j} i:${i}`);
                        }

                        judge_turn+=1;
                        // console.log("a");
                    }
                }
            }
        }
        
        if(count_canput_around==0){
            console.log(`セルの4方隣どれかに${color[-turn+1]}石がない`);
        }
        else if(count_canput_sand==0){
            console.log(`${color[turn+1]}石ではさめない`);
        }

    }
    else{
        console.log(`${vercellnum}${horcellnum}には既に石があります`);
    }

    if(judge_turn>0){
        turn*=-1;
        judge_turn=0;
    }
    
    makeboard();
    setrock();
}


function passTurn(){
    for (let p=1;p<=8;p+=1){
        for (let q=1;q<=8;q+=1){
            if(cellstate[p][q]==0){
                for(let i=-1;i<=1;i+=1){
                    for(let j=-1;j<=1;j+=1){
                        let dashy=p+i;
                        let dashx=q+j;
                        if(cellstate[dashy][dashx]==turn*100*(-1)){
                            while(cellstate[dashy][dashx]==turn*100*(-1) && dashx>=1 && dashx<=8 && dashy>=1 && dashy<=8){
                                dashx+=j;
                                dashy+=i;
                            }
                            if(cellstate[dashy][dashx]==turn*100){
                                judge_pass+=1;
                            }
                        }
                    }
                }    
            }       
        };
    };

    if(judge_pass>0){
        console.log("パスできない");
        judge_pass=0;
        continuous_pass=0;
    }
    else{
        turn*=-1;
        continuous_pass+=1;
        makeboard();
        setrock();
    }

    if(continuous_pass==2){
        endgame();
        console.log("end");
    }

}


function endgame(){
    let num_black=0;
    let num_white=0;
    let result;

    for (let i=1;i<=8;i+=1){
        for (let j=1;j<=8;j+=1){
            if(cellstate[i][j]==100){
                num_black+=1;
            }
            else if(cellstate[i][j]==-100){
                num_white+=1;
            }
        }
    }

    console.log(`黒石:${num_black} 白石:${num_white}`);

    if(num_black>num_white){
        result=`黒石:${num_black} 白石:${num_white}で黒の勝ち`
        console.log("黒の勝ち");
    }
    else if(num_black<num_white){
        result=`黒石:${num_black} 白石:${num_white}で白の勝ち`
        console.log("白の勝ち");
    }
    else{
        result=`黒石:${num_black} 白石:${num_white}で引き分け`
        console.log("引き分け");
    }

    document.getElementById("result").innerHTML=result;

}

