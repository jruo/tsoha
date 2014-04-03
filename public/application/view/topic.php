<?php defined('INDEX') or die; ?>
<div class="panel panel-default forum-post">
    <div class="panel-heading forum-post-heading"><div id="postid1">#1 <a href="#">Vastaa</a> | <a href="#">Muokkaa</a> | <a href="#">Poista</a></div></div>
    <div class="panel-body">
        <div class="col-sm-2">
            <small>20.3.2014 klo 18:00</small><br/>
            <a href="/tsoha/html-demo/profile.html">Matti Meikäläinen</a>
        </div>
        <div class="col-sm-10">
            Tervetuloa keskustelufoorumille! :3<br/><br/>- Matti
        </div>
    </div>
</div>

<div class="panel panel-primary forum-post">
    <div class="panel-heading forum-post-heading"><div id="postid3">#3 <a href="#">Vastaa</a> | <a href="#">Muokkaa</a> | <a href="#">Poista</a></div></div>
    <div class="panel-body">
        <div class="col-sm-2">
            <small>20.3.2014 klo 18:47</small><br/>
            <a href="/tsoha/html-demo/profile.html">Mikko Meikäläinen</a>
        </div>
        <div class="col-sm-10">
            <p><em><small>&gt; Vastaus viestiin <a href="#postid1">#1</a> käyttäjältä Matti Meikäläinen</small></em></p>
            Me gusta.
        </div>
    </div>
</div>

<hr>
<div class="panel panel-default forum-post-reply">
    <div class="panel-body">
        <div class="col-sm-2">
            <small>Vastaa ketjuun</small>
        </div>
        <div class="col-sm-10">
            <form role="form">
                <div class="form-group">
                    <!--<p><em><small>Viesti lähetetään vastauksena viestiin #3</small></em></p>-->
                    <textarea required class="form-control" id="forum-post-reply-form" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Vastaa</button>
                </div>
            </form>
        </div>
    </div>
</div>