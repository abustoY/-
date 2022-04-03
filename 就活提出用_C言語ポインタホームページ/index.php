<?php

function h($str)
{
  return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

if ($_SERVER['REQUEST_METHOD']==='POST'){
  $message=trim(filter_input(INPUT_POST,'message'));
  $message = $message!=='' ? $message : '...';
  
  $fp=fopen('messages.txt','a');
  fwrite($fp,$message . "\n");
  fclose($fp);

  header('Location: have_send.php');
  // header関数はこのスクリプトが終了した後に実行される。

}

$messages=file('messages.txt',FILE_IGNORE_NEW_LINES);

?>

<!DOCTYPE html>
<html>
<head lang="ja">
<meta charset="utf-8">
<title>C言語のポインタについて</title>
<meta name="description" content="C言語のポインタに焦点を当てたサイトです。ポインタのポインタなども扱っております。">
<meta name=”viewport” content=”width=257px,initial-scale=1”>
<link rel="stylesheet" href="css/reset.css"> 
<link rel="stylesheet" href="css/style.css"> 
</head>
<body>
<header>
  <h1 class="site_title">C言語のポインタについて</h1>
  <p class="last_modified">
  <?php
  $last_modified=filemtime("index.php");
  echo '最終更新日:' . date('Y-m-d',$last_modified);
  ?>
  </p>
  <h3>こちらのサイトは製作途中です。</h3>

  <div class="ad_div clearfix">
  <p>広告です</p>
  <?php 
  include('ad.php');
  ?>
  </div>

</header>
  
<section class="main_body">
<h2>目次</h2>
<ul class="index">
  <li>
    <a href="#theme1">
      パソコンのメモリとは
    </a>
  </li>
  <li>
    <a href="#theme2">
      メモリにはアドレスがふられている
    </a>
  </li>
  <li>
    <a href="#theme3">
      C言語はアドレスを利用したプログラムがかける
    </a>
  </li>
  <li>
    <a href="#theme4">
      ポインタとは、アドレスを値にもつ変数のこと    
    </a>
  </li>
  <li>
    <a href="#theme5">
      int型変数とポインタ型変数の比較
    </a>
  </li>
  <li>
    <a href="#theme6">
      実際ポインタをどう使うのか
    </a>
  </li>
</ul>

<h2 id="theme1">パソコンのメモリとは</h2>
<p class="p_theme1">メモリという言葉を聞いたことがあると思います。メモリとはコンピュータ内の作業テーブルのことです。実際に小さな物理的な部品として、コンピュータの中にあります。Googleで画像検索すればどのような見た目かわかります。パソコンやスマホを始め、コンピュータはメモリを持っています。パソコンのスペック表をみればメモリ8GBや16GBと記載があるのを見たことがあると思います。またアンドロイドスマホのスペック表にもRAM6GBなど書いております。RAMとはメモリの別名のようなものととらえて頂いて大丈夫です。6GB等これらの値はメモリの容量のことです。先ほどメモリは作業テーブルと申し上げましたが、数字が大きいほどテーブルが大きいということです。つまり数字が大きければ大きいほど、コンピューターが同時に処理できる命令が増えます。
さて、「コンピューターは0と1しか認識できない」だったり、「機械語は0と1の羅列で人間にはわかりづらいからプログラミング言語が生まれた」などといわれています。つまりコンピューターは0と1を認識できるということですが、なぜでしょう。<br>
半導体という物質をご存知でしょうか。半導体は条件によって、電気を通したり通さなかったりする物質です。この通っている状態を0、通っていない状態を1と人間が決めました。よって半導体1つで情報を2つ分もてるわけです。そしてコンピューターはたくさんの半導体から構成されています。つまり電気が通っているか通っていないかを認識しているだけで、人間がそれに0と1という名前をつけたのです。だから「コンピューターはyesとnoしか認識できない」だったり「コンピューターは50と1423425しか認識できない」といってもいいわけです。<br>メモリもたくさんの半導体から構成されています。半導体を数えるときbitという単位を使います。1個は1bit、20個は20bitと数えるわけです。8bitのことを1byteと呼びます。メモリでは1byteが基本単位となります。1byteは情報を何個分持てるでしょうか？1bitで2個分情報を持てるということは2^8=256個分持てます。
</p>

<h2 id="theme2">メモリにはアドレスがふられている</h2>
<p class="p_theme2">メモリは1byteごとに半導体をまとめてあつかいます。いわば1byteはメモリの基本単位です。1byteごとにことなった数が割り当てられています。0,1,2,...という正の数です。この割り当てられた数のことをアドレスと呼びます。アドレスはそれぞれのbyteの住所のようなものです。</p>

<h2 id="theme3">C言語はアドレスを利用したプログラムがかける</h2>
<p class="p_theme3">ここからC言語の話です。C言語はアドレスを利用したプログラムがかけます。例えば「ある情報をアドレス500番に格納して」や「アドレス1000番に格納されているint型の変数とアドレス3番に格納されているint型の変数を足し算して」という命令がC言語ならできます。PythonやJavascriptでこのような命令の仕方は私は見たことがありません。</p>

<h2 id="theme4">ポインタとは、アドレスを値に持つ変数のこと</h2>
<p class="p_theme4">前置きが長くなりましたがここでポインタの登場です。ポインタはアドレスを値に持つ変数のことです。int型の変数が3という整数を値に持つように、ポインタ型の変数が600というアドレスを値に持ちます。</p>

<h2 id="theme5">int型変数とポインタ変数の比較</h2>
<p class="p_theme5">実際にポインタ型変数を宣言するとき、</p>
<pre>
<code class="c">int* p = 1000;</code></pre>
<p class="p_theme5">
のように書きます。int型変数の宣言、
</p>
<pre>
<code class="c">int a = 10;</code></pre>
<p class="p_theme5">
と同じ形式であることがおわかり頂けると思います。
「ポインタ」という言葉の持つ意味は文脈によってかわることがあるのですが、とりあえずこのサイトで書いた「ポインタとは、アドレスを値に持つ変数のこと」と覚えておけば、勉強を
進めていくうちにわかるようになりますので心配ありません。

</p>
<!-- /p_theme5 -->

<h2 id="theme6">実際ポインタをどう使うのか</h2>
<p class="p_theme6">ところで、上のような</p>
<pre>
<code class="c">int* p = 1000;</code></pre>
<p class="p_theme6">
というようなポインタ変数pを具体的な数(ここでは1000)で初期化する文は、見たことがないと思います。一般的なC言語の入門書では
</p>
<pre>
<code class="c">int* p = &a;</code></pre>
<p class="p_theme6">
このような文が書かれていたはずです。実際ポインタは後者のように使います。それでは
</p>
<pre>
<code class="c">int* p = &a;</code></pre>
<p class="p_theme6">
というような文が何をしているか見ていきましょう。以下のサンプルコードを見てください。
</p>
<pre>
<code class="c">
# include &ltstdio.h&gt

int main(void)
{
  int a = 20;
  printf("&a..%p\n",&a);
  int* p = &a;
  printf("p..%p\n",p);
  
  return 0;
}
</code></pre>
<p class="p_theme6">
まずint型の変数aを宣言しています。初期値20は適当です。
変数はメモリ上に保存されます。メモリ上のどこかに保存されているから、
</p>
<pre>
<code class="c"> printf("%d",a);</code></pre>
<p class="p_theme6">
と書いたときにコンピューターがaとはなにか認識できて、ちゃんと20が表示されるのです。<br>変数がメモリ上のどこかに保存されると言いましたが、そのどこかを求められる便利な演算子が
</p>
<pre>
<code class="c"> printf("&a..%p\n",&a);</code></pre>
<p class="p_theme6">
の文に出てくる「&」です。要するに「&」は変数のアドレスを求める演算子です。このサンプルコードをコピーして実行してみてください。「&a..数字」と表示されます。この数字が変数aのアドレスです。そして
</p>
<pre>
<code class="c">int* p = &a;</code></pre>
<p class="p_theme6">
ポインタ変数pをaのアドレスで初期化しております。「ポインタとは、アドレスを値に持つ変数のこと」でした。ここで確かに、ポインタpはaのアドレスを値に持つ変数ですね。<br>もうサンプルコードを実行してしまったので
</p>
<pre>
<code class="c"> printf("p..%p\n",p);</code></pre>
<p class="p_theme6">
でなにが表示されるか見てしまっていると思いますが、予想してみましょう。ポインタpはaのアドレスを値に持つ変数なので
</p>
<pre>
<code class="c"> printf("&a..%p\n",&a);</code></pre>
<p class="p_theme6">
と同じ数字が表示されることを、ご確認いただけたと思います。
</p>
</section>
<!-- /main_body -->

<footer>

<div>
<p>質問がございましたらぜひこちらからどうぞ(このページに掲載されます)</p>
<?php 
include('ask_form.php');
?>
</div>

</footer>


</body>
</html>