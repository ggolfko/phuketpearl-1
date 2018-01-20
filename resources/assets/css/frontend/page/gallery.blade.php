html, body {
    overflow-x: hidden;
    background-color: #000;
}

.ui-gallery {
    position: relative;
    min-height: 100vh;
    padding-top: 100px;
    padding-bottom: 40px;
    background-color: #000;
}
.ui-gallery.xs {
    padding-top: 70px !important;
}
.ui-gallery .head {
    position: relative;
    width: 100%;
    height: 40px;
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: center;
}
.ui-gallery .head .title {
    position: absolute;
    left: 0px;
    top: -14px;
    width: 100%;
}
.ui-gallery .head .title span {
    padding: 0px 10px;
    background-color: #000;
    font-family: 'Gotham 4r', sans-serif;
    font-weight: 400;
    font-size: 19px;
    color: #f4f4f4;
}
.ui-gallery .head .line {
    display: block;
    border: none;
    color: #fff;
    height: 1px;
    background: black;
    background: gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -moz-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
}
.ui-gallery .head-long {
    position: relative;
    width: 100%;
    margin-top: 0px;
    margin-bottom: 40px;
    text-align: center;
}
.ui-gallery .head-long span {
    padding: 0px 10px;
    background-color: #000;
    font-family: 'Gotham 4r', sans-serif;
    font-weight: 400;
    font-size: 17.5px;
    color: #f4f4f4;
}
.ui-gallery .index {
    position: relative;
    text-align: center;
    margin-bottom: 50px;
}
.ui-gallery .index a {
    position: relative;
    display: block;
    text-align: left;
    border-radius: 2.5px;
    -webkit-border-radius: 2.5px;
    -moz-border-radius: 2.5px;
    overflow: hidden;
}
.ui-gallery .index img {
    display: block;
    width: 100%;
    border-radius: 2.5px;
    -webkit-border-radius: 2.5px;
    -moz-border-radius: 2.5px;
}
.ui-gallery .index a .title {
    position: absolute;
    left: 0px;
    bottom: 0px;
    width: 100%;
    background-attachment: scroll;
    background-size: auto;
    background-image: url('/static/images/gallery-title.png');
    background-origin: padding-box;
    background-clip: border-box;
    background-position: bottom;
    background-repeat: repeat-x;
    padding: 10px 12px 0px 12px;
}
.ui-gallery .index a .title .text {
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    font-size: 15px;
    line-height: 20px;
    margin-bottom: 26px;
}
.ui-gallery .album {
    position: relative;
    text-align: center;
    margin-bottom: 50px;
}
.ui-gallery .album a {
    position: relative;
    display: block;
    text-align: left;
    border-radius: 1.8px;
    -webkit-border-radius: 1.8px;
    -moz-border-radius: 1.8px;
    overflow: hidden;
}
.ui-gallery .album img {
    display: block;
    width: 100%;
    border-radius: 1.8px;
    -webkit-border-radius: 1.8px;
    -moz-border-radius: 1.8px;
}
