html, body {
    overflow-x: hidden;
    background-color: #000;
}
.style-ui-alert .opentip {
    padding: 6px 11px;
}
.style-ui-alert .ot-content {
    font-size: 10px;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif !important;
    color: #fff;
}

.ui-jewels {
    position: relative;
    min-height: 100vh;
    padding-top: 100px;
    padding-bottom: 40px;
    background-color: #000;
}
.ui-jewels.xs {
    padding-top: 80px !important;
}
.ui-jewels .list {
    position: relative;
}
.ui-jewels .list .head {
    position: relative;
    width: 100%;
    height: 40px;
    margin-top: 18px;
    margin-bottom: 10px;
    text-align: center;
}
.ui-jewels .list .head.xs {
    margin-top: 0px !important;
}
.ui-jewels .list .head .category {
    position: absolute;
    left: 0px;
    top: -15px;
    width: 100%;
}
.ui-jewels .list .head .category span {
    padding: 0px 10px;
    background-color: #000;
    font-family: 'Gotham 4r', sans-serif;
    font-weight: 400;
    font-size: 20px;
    color: #f4f4f4;
}
.ui-jewels .list .head .line {
    display: block;
    border: none;
    color: #fff;
    height: 1px;
    background: black;
    background: gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -moz-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
}
.ui-jewels .list .item {
    position: relative;
    display: block;
    position: relative;
    font-family: 'Gotham 3r', sans-serif;
    font-weight: 400;
    font-size: 16px;
    color: #f4f4f4;
    text-align: center;
    text-decoration: none;
    margin-bottom: 60px;
}
.ui-jewels .list .item .image {
    position: relative;
}
.ui-jewels .list .item .image img {
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
}
.ui-jewels .list .item .info {
    position: relative;
    padding-top: 20px;
}
.ui-jewels .list .item .info.fixheight {
    height: 60px;
    overflow: hidden;
}

.ui-jewels .product {
    position: relative;
}
.ui-jewels .product .head {
    position: relative;
    width: 100%;
    height: 40px;
    margin-top: 20px;
    margin-bottom: 30px;
    text-align: center;
}
.ui-jewels .product .head.xs {
    margin-top: 0px !important;
}
.ui-jewels .product .head .title {
    position: absolute;
    left: 0px;
    top: -14px;
    width: 100%;
}
.ui-jewels .product .head .title span {
    padding: 0px 10px;
    background-color: #000;
    font-family: 'Gotham 4r', sans-serif;
    font-weight: 400;
    font-size: 19px;
    color: #f4f4f4;
}
.ui-jewels .product .head .line {
    display: block;
    border: none;
    color: #fff;
    height: 1px;
    background: black;
    background: gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -webkit-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
    background: -moz-gradient(radial, 50% 50%, 0, 50% 50%, 450, from(rgba(244,244,244,.7)), to(rgba(0,0,0,.7)));
}
.ui-jewels .product .images {
    position: relative;
    margin-bottom: 50px;
}
.ui-jewels .product .images .thumbs {
    position: relative;
}
.ui-jewels .product .images .thumbs .arrow-up {
    position: absolute;
    display: block;
    top: 0px;
    left: 0px;
    z-index: 1000;
    width: 100%;
    text-align: center;
    background-color: rgba(0, 0, 0, .3);
    border: 1px solid #000;
    border-radius: 2px 2px 0 0;
    -webkit-border-radius: 2px 2px 0 0;
    -moz-border-radius: 2px 2px 0 0;
}
.ui-jewels .product .images .thumbs .arrow-up:hover {
    background-color: rgba(255,255,255,.25);
    -webkit-transition: background .4s ease-out;
    -moz-transition: background .4s ease-out;
    -o-transition: background .4s ease-out;
    transition: background .4s ease-out;
}
.ui-jewels .product .images .thumbs .arrow-up i {
    font-size: 20px;
    color: #f4f4f4;
}
.ui-jewels .product .images .thumbs .arrow-down {
    position: absolute;
    display: block;
    bottom: 0px;
    left: 0px;
    z-index: 1000;
    width: 100%;
    text-align: center;
    background-color: rgba(0, 0, 0, .3);
    border: 1px solid #000;
    border-radius: 0 0 3px 3px;
    -webkit-border-radius: 0 0 3px 3px;
    -moz-border-radius: 0 0 3px 3px;
}
.ui-jewels .product .images .thumbs .arrow-down:hover {
    background-color: rgba(255,255,255,.25);
    -webkit-transition: background .4s ease-out;
    -moz-transition: background .4s ease-out;
    -o-transition: background .4s ease-out;
    transition: background .4s ease-out;
}
.ui-jewels .product .images .thumbs .arrow-down i {
    font-size: 20px;
    color: #f4f4f4;
}
.ui-jewels .product .images .thumbs .list {
    position: relative;
    overflow: hidden;
}
.ui-jewels .product .images .thumbs .list.minimize {
    height: 0px;
}
.ui-jewels .product .images .thumbs .list .items {
    position: relative;
}
.ui-jewels .product .images .thumbs .list .items .thumb {
    position: relative;
    display: block;
    border: 1px solid #000;
    background-color: #000;
}
.ui-jewels .product .images .thumbs .list .items .thumb.focus img {
    opacity: 1;
    filter: alpha(opacity=100);
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    -webkit-transition: opacity .12s ease-in-out;
    -moz-transition: opacity .12s ease-in-out;
    -ms-transition: opacity .12s ease-in-out;
    -o-transition: opacity .12s ease-in-out;
    transition: opacity .12s ease-in-out;
}
.ui-jewels .product .images .thumbs .list .items .thumb img {
    position: relative;
    display: block;
    max-width: 100%;
    border: 1px solid #000;
    opacity: 0.7;
    filter: alpha(opacity=70);
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
}
.ui-jewels .product .images .thumbs .list .items.nopointer .thumb img {
    margin: 2px 0px;
}
.ui-jewels .product .images .display {
    position: relative;
}
.ui-jewels .product .images .display a {
    display: block;
}
.ui-jewels .product .images .display a img {
    display: block;
    max-width: 100%;
}
.ui-jewels .product .info {
    position: relative;
    margin-bottom: 50px;
}
.ui-jewels .product .info .text {
    background-color: #000;
    font-family: 'Gotham 3r', sans-serif;
    font-weight: 400;
    font-size: 12.5px;
    color: #f4f4f4;
    margin-bottom: 11px;
}
.ui-jewels .product .info .text span {
    text-transform: uppercase;
    margin-right: 7px;
    display: inline-block;
    min-width: 100px;
}
.ui-jewels .product .info .text.moredetail {
    margin-top: 28px;
}
.ui-jewels .product .info .contact {
    background-color: #000;
    margin-top: 55px;
}
.ui-jewels .product .info .contact a {
    font-size: 11.8px;
    margin-right: 25px;
    text-decoration: none;
}
.ui-jewels .product .info .contact a:last-child {
    margin-right: 0px;
}
.ui-jewels .product .info .contact a:hover span {
    text-decoration: underline;
}
.ui-jewels .product .info .contact a i {
    margin-right: 9px;
    display: inline-block;
    vertical-align: middle;
}
.ui-jewels .product .info .contact a .ion-reply-all {
    font-size: 21px;
}
.ui-jewels .product .info .contact a .ion-clipboard {
    font-size: 17px;
}
.ui-jewels .product .info .contact a span {
    display: inline-block;
    vertical-align: middle;
}
.ui-jewels .product .enquiry {
    position: relative;
}
.ui-jewels .product .enquiry h2 {
    color: #fff;
    font-size: 19px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    margin-bottom: 20px;
}
.ui-jewels .product .enquiry .row label {
    color: #fff;
    font-size: 12.5px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
}
.ui-jewels .product .enquiry input[type=text],
.ui-jewels .product .enquiry textarea,
.ui-jewels .product .enquiry select {
    display: block;
    background-color: rgb(51, 51, 51);
    width: 100%;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 12.5px !important;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
       -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.ui-jewels .product .enquiry select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
}
.ui-jewels .product .enquiry button.btn {
    font-size: 12px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    padding: 8px 14px;
    margin-top: 7px;
    border: 1px solid #fff;
    color: #fff;
    background-color: rgb(51, 51, 51);
    text-transform: uppercase;
    -webkit-transition: .5s all;
}
.ui-jewels .product .enquiry button.btn:hover {
    background-color: #fff;
    color: #000;
}
.ui-jewels .product .enquiry button.btn:disabled {
    background-color: rgb(51, 51, 51) !important;
    color: #fff !important;
}
.ui-jewels .product .hooks {
    position: relative;
    margin-bottom: 40px;
}
.ui-jewels .product .hooks h2 {
    color: #fff;
    font-size: 17px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    margin-bottom: 20px;
    text-decoration: underline;
}
.ui-jewels .product .hooks .items {
    position: relative;
    overflow-x: auto;
}
.ui-jewels .product .hooks .table th {
    color: #fff;
    font-family: 'Gotham 4r', sans-serif;
    font-size: 12.5px;
}
.ui-jewels .product .hooks .table td {
    color: #fff;
    font-family: 'Gotham 3r', sans-serif;
    font-size: 12.5px;
}
.ui-jewels .product .hooks .table td:hover {
    background-color: rgba(255,255,255,.2);
}
.ui-jewels .product .hooks .table {
    border: 1px solid #000;
}
.ui-jewels .product .hooks .table thead th {
    border: none;
}
.ui-jewels .product .hooks .table .item {
    position: relative;
    min-width: 100px;
}
.ui-jewels .product .hooks .table td:first-child .item {
    min-width: 80px;
}
.ui-jewels .product .hooks .table .item .image {
    position: relative;
    text-align: center;
    margin-bottom: 8px;
}
.ui-jewels .product .hooks .table .item .image a {
    position: relative;
    display: block;
    width: 80px;
    height: 80px;
    margin: 0 auto;
}
.ui-jewels .product .hooks .table .item .image a img {
    display: block;
    width: 100%;
    height: 100%;
    border: 1px solid #000;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
}
.ui-jewels .product .hooks .table .item .input {
    position: relative;
    text-align: center;
}
.ui-jewels .product .hooks .table .item .text {
    position: relative;
    text-align: center;
    margin-top: 8px;
}
.ui-jewels .product .hooks .table .item .text.left {
    text-align: left;
    margin-top: 0px;
}
.ui-jewels .product .hooks .table .item .text.top {
    margin-top: 0px;
    padding-bottom: 11px;
}

.ui-jewels-sweetalert p {
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    font-size: 13.5px;
    color: #333;
}
.ui-jewels-sweetalert .confirm {
    font-family: 'Gotham 3r', sans-serif;
    font-size: 14px;
    padding: 9px 20px;
}
