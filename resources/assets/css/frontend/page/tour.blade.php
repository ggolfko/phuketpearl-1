html, body {
    overflow-x: hidden;
    background-color: #000;
}
html.fixed {
    overflow-y: hidden;
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
.termsModal .modal-title {
    font-size: 14.5px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
}
.termsModal .modal-body {
    padding: 0px;
    height: calc(100vh - 90px);
}
.termsModal .modal-body iframe {
    border: none;
    width: 100%;
    height: 100%;
}
.termsModal .modal-header .close {
    outline: none;
}
.termsModal {
    padding: 23px 80px !important;
    height: 100vh !important;
    overflow: hidden !important;
}
.termsModal.sm {
    padding: 21px 50px !important;
}
.termsModal.sm .modal-body {
    height: calc(100vh - 88px);
}
.termsModal.xs {
    padding: 12px 10px !important;
}
.termsModal.xs .modal-body {
    height: calc(100vh - 82px);
}
.termsModal .modal-dialog {
    width: 100%;
    margin: 0px !important;
}
.alert-danger {
    font-weight: 600 !important;
    font-family: 'Gotham 3r', sans-serif;
    line-height: 21px;
    font-size: 12.5px;
    background-color: #ecd0d0 !important;
    color: #8a0a07 !important;
    padding-top: 13px;
    padding-bottom: 13px;
    border: 1px solid #8a0a07;
}
.alert-danger.th {
    font-weight: 400 !important;
    font-size: 13.5px !important;
}
.datepicker-days .disabled {
    background-color: #f4f4f4 !important;
    border-radius: 0px !important;
    -webkit-border-radius: 0px !important;
    -moz-border-radius: 0px !important;
}

.ui-tour {
    position: relative;
    min-height: 100vh;
    padding-top: 100px;
    padding-bottom: 40px;
    background-color: rgb(249, 249, 249);
}
.ui-tour.xs {
    padding-top: 70px !important;
}
.ui-tour .ribbon.popular {
  position: absolute;
  left: -5px; top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 75px; height: 75px;
  text-align: right;
}
.ui-tour .ribbon.popular span {
  font-size: 10px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  width: 100px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#F70505 0%, #8F0808 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 19px; left: -21px;
}
.ui-tour .ribbon.popular span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #8F0808;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #8F0808;
}
.ui-tour .ribbon.popular span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #8F0808;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #8F0808;
}
.ui-tour .ribbon.new {
  position: absolute;
  left: -5px; top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 75px; height: 75px;
  text-align: right;
}
.ui-tour .ribbon.new span {
  font-size: 10px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  width: 100px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#9BC90D 0%, #79A70A 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 19px; left: -21px;
}
.ui-tour .ribbon.new span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #79A70A;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
.ui-tour .ribbon.new span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #79A70A;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
.ui-tour .ribbon.recommended {
  position: absolute;
  left: -5px; top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 75px; height: 75px;
  text-align: right;
}
.ui-tour .ribbon.recommended span {
  font-size: 10px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  width: 100px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#2989d8 0%, #1e5799 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 19px; left: -21px;
}
.ui-tour .ribbon.recommended span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #1e5799;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #1e5799;
}
.ui-tour .ribbon.recommended span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #1e5799;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #1e5799;
}
.ui-tour > .index .item {
    position: relative;
    display: block;
    background-color: #fff;
    margin-bottom: 30px;
    box-shadow: 0 0 5px 0 rgba(0,0,0,.1);
    -webkit-box-shadow: 0 0 5px 0 rgba(0,0,0,.1);
    -moz-box-shadow: 0 0 5px 0 rgba(0,0,0,.1);
}
.ui-tour > .index .item .images {
    position: relative;
    display: block;
    border: 1px solid #fff;
    overflow: hidden;
}
.ui-tour > .index .item .images a {
    display: block;
}
.ui-tour > .index .item .images a img {
    display: block;
    width: 100%;
}
.ui-tour > .index .item .images a img.transition {
    transition: all .5s ease-in-out;
}
.ui-tour > .index .item .images a:hover img.transition {
    transform: scale(1.15);
}
.ui-tour > .index .item .images a .description {
    position: absolute;
    left: 0px;
    bottom: 0px;
    width: 100%;
    background-attachment: scroll;
    background-size: auto;
    background-image: url('/static/images/tour-description.png');
    background-origin: padding-box;
    background-clip: border-box;
    background-position: bottom;
    background-repeat: repeat-x;
    padding: 10px 12px 0px 12px;
}
.ui-tour > .index .item .images a .description .price {
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    display: block;
    float: left;
    margin-bottom: 7px;
}
.ui-tour > .index .item .images a .description .price .amount {
    font-size: 19px;
    display: block;
}
.ui-tour > .index .item .images a .description .price .type {
    font-size: 13px;
    display: block;
}
.ui-tour > .index .item .images a .description .contact {
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    display: block;
    float: right;
    margin-bottom: 7px;
}
.ui-tour > .index .item .images .previews {
    display: block;
    position: absolute;
    bottom: 10px;
    right: 12px;
}
.ui-tour > .index .item .images .previews a {
    position: relative;
    display: block;
}
.ui-tour > .index .item .images .previews a i {
    color: #fff;
    font-size: 18.5px;
}
.ui-tour > .index .item .info {
    position: relative;
    display: block;
    padding: 8px 12px 12px 12px;
    height: 63px;
    overflow: hidden;
}
.ui-tour > .index .item .info .title {
    font-size: 16px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    line-height: 21px;
}

.ui-tour > .detail .main {
}
.ui-tour > .detail .main .images {
    position: relative;
    margin-bottom: 12px;
}
.ui-tour > .detail .main .images img {
    max-width: 100%;
    width: 100%;
    cursor: default;
}
.ui-tour > .detail .main .images .top {
    position: absolute;
    top: 0px;
    left: 0px;
    background-attachment: scroll;
    background-size: auto;
    background-image: url('/static/images/tour-detail-top.png');
    background-origin: padding-box;
    background-clip: border-box;
    background-position: top;
    background-repeat: repeat-x;
    padding: 10px 17px 0px 17px;
    width: 100%;
    z-index: 10;
}
.ui-tour > .detail .main .images .top .title {
    color: #fff;
    font-size: 21.5px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    display: block;
    float: left;
    padding-top: 7px;
    padding-bottom: 80px;
    line-height: 27px;
}
.ui-tour > .detail .main .images .bottom {
    position: absolute;
    bottom: 0px;
    left: 0px;
    background-attachment: scroll;
    background-size: auto;
    background-image: url('/static/images/tour-detail-bottom.png');
    background-origin: padding-box;
    background-clip: border-box;
    background-position: bottom;
    background-repeat: repeat-x;
    padding: 10px 15px 0px 15px;
    width: 100%;
}
.ui-tour > .detail .main .images .bottom .price {
    float: right;
    display: block;
    position: relative;
    color: rgb(52, 143, 226);
    font-size: 45.2px;
    font-weight: 500;
    font-family: 'Gotham 5r', sans-serif;
    line-height: normal;
    display: block;
    float: right;
    margin-bottom: 10px;
    margin-top: 70px;
    padding-left: 11px;
}
.ui-tour > .detail .main .images .bottom .price-type {
    float: right;
    display: block;
    position: relative;
    margin-bottom: 10px;
    margin-top: 70px;
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    line-height: normal;
}
.ui-tour > .detail .main .images .bottom .price-type .unit {
    position: relative;
    float: right;
    font-size: 17px;
    padding-top: 8px;
    margin-right: -3px;
}
.ui-tour > .detail .main .images .bottom .price-type .type {
    position: relative;
    float: right;
    clear: both;
    padding-top: 1px;
    font-size: 13px;
}
.ui-tour > .detail .main hr {
    border-top: 1px solid rgb(221, 221, 221);
    display: block;
    width: 100%;
    height: 0px;
}
.ui-tour > .detail .main .time {
    position: relative;
    display: block;
    font-size: 11.5px;
    font-weight: 400;
    font-family: 'Gotham SSm 5r', sans-serif;
    line-height: 16px;
    margin-bottom: 5px;
    text-transform: uppercase;
    color: #333;
}
.ui-tour > .detail .main .time a {
    margin-right: 8px;
    color: #333;
}
.ui-tour > .detail .main .time a .fa {
    font-size: 15px;
}
.ui-tour > .detail .main .map {
    position: relative;
    margin-bottom: 20px;
}
.ui-tour > .detail .main .map .display {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
}
.ui-tour > .detail .main .highlight {
    margin-bottom: 20px;
}
.ui-tour > .detail .main .highlight .head {
    font-size: 16.5px;
    font-weight: 500;
    font-family: 'Gotham 4r', sans-serif;
    text-transform: uppercase;
    color: #333;
}
.ui-tour > .detail .main .highlight .text {
    position: relative;
    display: block;
    margin-bottom: 6px;
}
.ui-tour > .detail .main .highlight .text ul {
    padding-left: 0px;
}
.ui-tour > .detail .main .highlight .text ul li {
    display: block;
    font-size: 13.5px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 21px;
    margin-bottom: 5px;
}
.ui-tour > .detail .main .highlight .text ul li .fa {
    font-size: 15px;
}
.ui-tour > .detail .main .content {
    position: relative;
    display: block;
    font-size: 14.5px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 21px;
    margin-bottom: 6px;
    padding: 0px;
}
.ui-tour > .detail .main .content p {
    font-size: 13.5px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 21px;
}
.ui-tour > .detail .main .content a {
    text-decoration: underline;
}
.ui-tour > .detail .main .content img {
    max-width: 100%;
}
.ui-tour > .detail .main .content iframe {
    max-width: 100%;
}
.ui-tour > .detail .main .tour-note {
    margin-bottom: 20px;
}
.ui-tour > .detail .main .tour-note .head {
    font-size: 16.5px;
    font-weight: 500;
    font-family: 'Gotham 4r', sans-serif;
    text-transform: uppercase;
    color: #333;
}
.ui-tour > .detail .main .tour-note .text {
    position: relative;
    display: block;
    font-size: 13.5px !important;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 21px;
    margin-bottom: 6px;
}
.ui-tour > .detail .main .keywords {
    margin-bottom: 20px;
}
.ui-tour > .detail .main .keywords .head {
    font-size: 16.5px;
    font-weight: 500;
    font-family: 'Gotham 4r', sans-serif;
    text-transform: uppercase;
    color: #333;
}
.ui-tour > .detail .main .keywords .text .label {
    font-size: 11.5px;
    font-weight: 400;
    font-family: 'Gotham SSm 3r', sans-serif;
    line-height: 21px;
    padding: 3px 8px;
}

.ui-tour > .detail .book {
    position: relative;
    border: 1px solid rgb(221, 221, 221);
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    background-color: #fff;
}
.ui-tour > .detail .book h3 {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 21px;
    font-weight: 500;
    font-family: 'Gotham 3r', sans-serif;
    text-align: center;
    line-height: normal;
    background-color: #565a5c;
    color: #fff;
    border: 1px solid #fff;
}
.ui-tour > .detail .book .price-type {
    position: relative;
    display: block;
    padding: 3px 20px 10px 20px;
    font-size: 15.5px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
    text-transform: uppercase;
    color: #000;
    margin-bottom: 3px;
}
.ui-tour > .detail .book .price-type.th {
    font-weight: 400 !important;
    font-size: 16.5px;
}
.ui-tour > .detail .book .describe {
    position: relative;
    display: block;
    padding: 0px 20px 7px 20px;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
    color: #000;
}
.ui-tour > .detail .book .describe.th {
    font-weight: 400 !important;
    font-size: 14.5px;
}
.ui-tour > .detail .book .describe .ui-small {
    font-size: 12px;
}
.ui-tour > .detail .book .form {
    position: relative;
    display: block;
    padding: 0px 20px 10px 20px;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
    color: #000;
}
.ui-tour > .detail .book .form.th {
    font-weight: 400 !important;
    font-size: 14.5px;
}
.ui-tour > .detail .book .form input[type=text] {
  display: block;
  width: 100%;
  height: 40px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555;
  cursor: pointer;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
  -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
       -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.ui-tour > .detail .book .form input[type=text]:focus {
  border-color: #66afe9;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
}
.ui-tour > .detail .book .form .group input[type=text] {
    border-radius: 0px !important;
    -moz-border-radius: 0px !important;
    -webkit-border-radius: 0px !important;
    text-align: center;
}
.ui-tour > .detail .book .form .group .input-group-addon {
    background-color: #fff !important;
    cursor: pointer;
    border: 1px solid #ccc;
    padding-left: 15px;
    padding-right: 15px;
    font-size: 16px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.ui-tour > .detail .book .form .group .input-group-addon:first-child {
    border-right: none !important;
}
.ui-tour > .detail .book .form .group .input-group-addon:last-child {
    border-left: none !important;
}
.ui-tour > .detail .book .form .ui-label {
    display: block;
    margin-bottom: 5px;
}
.ui-tour > .detail .book .form .fa {
    color: #858585;
}
.ui-tour > .detail .book .form hr {
    margin-left: 10px;
    margin-right: 10px;
}
.ui-tour > .detail .book .calc {
    position: relative;
    display: block;
    padding: 0px 20px 10px 20px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
    color: #000;
}
.ui-tour > .detail .book .calc.th {
    font-weight: 400 !important;
    font-size: 14px;
}
.ui-tour > .detail .book .calc table {
    width: 100%;
}
.ui-tour > .detail .book .calc table tr {
    border-top: 1px solid #f3f3f3;
}
.ui-tour > .detail .book .calc table tr td {
    padding: 7px 0px 7px 0px;
}
.ui-tour > .detail .book .calc table tr td:first-child {
    text-align: left;
}
.ui-tour > .detail .book .calc table tr td:last-child {
    text-align: right;
}
.ui-tour > .detail .book .calc table tr.total td {
    color: #bd0c00;
    text-transform: uppercase;
    font-size: 18px;
    font-family: 'Gotham 5r', sans-serif;
}
.ui-tour > .detail .book .book-now {
    padding: 10px 30px 24px 30px;
}
.ui-tour > .detail .book .book-now .btn {
    width: 100%;
    font-size: 16px;
    font-weight: 800;
    font-family: 'Gotham 4r', sans-serif;
    text-transform: uppercase;
    padding: 10px;
}
.ui-tour > .detail .book .book-now .btn.cancel {
    border: 2px solid #348fe2;
    background-color: #fff;
    margin-top: 10px;
    color: #348fe2;
    font-size: 13.5px;
}
.ui-tour > .detail .book .book-now .btn.cancel:hover {
    border: 2px solid #337ab7;
    color: #337ab7;
}
.ui-tour > .detail .book .terms {
    position: relative;
    margin-bottom: 8px;
}
.ui-tour > .detail .book .terms a {
    font-size: 13px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    color: #000;
    margin-left: 3px;
}

.ui-tour > .detail .phone-contact {
    position: relative;
    border: 1px solid rgb(221, 221, 221);
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    background-color: #fff;
    margin-top: 25px;
    padding: 18px 20px 35px 20px;
    text-align: center;
}
.ui-tour > .detail .phone-contact:before {
    border-bottom: 10px solid #ccc;
    margin-bottom: 0;
    content: "";
    position: absolute;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    bottom: 100%;
    left: 50%;
    margin-left: -10px;
}
.ui-tour > .detail .phone-contact:after {
    border-bottom: 10px solid #fff;
    margin-bottom: -1px;
    z-index: 1;
    content: "";
    position: absolute;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    bottom: 100%;
    left: 50%;
    margin-left: -10px;
}
.ui-tour > .detail .phone-contact img {
    width: 78px;
}
.ui-tour > .detail .phone-contact .text {
    font-size: 15px;
    font-weight: 800;
    font-family: 'Gotham 4r', sans-serif;
    color: #000;
}
.ui-tour > .detail .phone-contact .phone,
.ui-tour > .detail .phone-contact .phone a {
    font-size: 20px;
    font-weight: 900;
    font-family: 'Gotham SSm 4r', sans-serif;
    margin-top: 7px;
    color: #348fe2;
}
.ui-tour > .detail .phone-contact .contact {
    margin-top: 15px;
}
.ui-tour > .detail .phone-contact .contact a {
    font-size: 11.5px;
    font-weight: 900;
    font-family: 'Gotham 4r', sans-serif;
    color: #000;
}
.ui-tour > .detail .phone-contact .contact a.th {
    font-weight: 400 !important;
    font-size: 13px;
}

.ui-tour > .checkout .main .title {
    color: #333;
    font-size: 21.5px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    line-height: 27px;
    position: relative;
    margin-bottom: 25px;
}
.ui-tour > .checkout .main .title a {
    color: #6e6e6e;
}
.ui-tour > .checkout .main .step {
    position: relative;
    padding-left: 20px;
    margin-bottom: 15px;
}
.ui-tour > .checkout .main .step .section {
    border-left: 1px solid rgb(221, 221, 221);
    padding-left: 32px;
    padding-right: 10px;
    padding-bottom: 15px;
    font-family: 'Gotham 4r', sans-serif;
    font-size: 13px;
}
.ui-tour > .checkout .main .step .section .head {
    position: relative;
    margin-bottom: 5px;
}
.ui-tour > .checkout .main .step .section .head .number {
    text-align: center;
    vertical-align: top;
    line-height: 40px;
    display: inline-block;
    margin-left: -52px;
    padding-bottom: 10px;
    background-color: rgb(249, 249, 249);
}
.ui-tour > .checkout .main .step .section .head .number span {
    display: block;
    background-color: #a07936;
    width: 40px;
    height: 40px;
    font-size: 18px;
    font-weight: 900;
    font-family: 'Gotham 4r', sans-serif;
    color: #fff;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
}
.ui-tour > .checkout .main .step .section .head .text {
    position: relative;
    display: inline-block;
    vertical-align: top;
    padding-left: 9px;
}
.ui-tour > .checkout .main .step .section .head .text h2 {
    font-size: 18px;
    font-weight: 600;
    font-family: 'Gotham 4r', sans-serif;
    line-height: normal;
    margin: 0px;
    padding: 0px;
}
.ui-tour > .checkout .main .step .section .head .text h2.th {
    font-weight: 400 !important;
}
.ui-tour > .checkout .main .step .section .head .text h3 {
    font-size: 11.5px;
    font-weight: 550;
    font-family: 'Gotham 4r', sans-serif;
    line-height: normal;
    color: #959595;
    margin: 0px;
    padding: 0px;
    margin-top: 3px;
}
.ui-tour > .checkout .main .step input[type=text],
.ui-tour > .checkout .main .step select,
.ui-tour > .checkout .main .step textarea {
    display: block;
    width: 100%;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-family: 'Gotham 4r', sans-serif;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
       -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.ui-tour > .checkout .main .step input[type=text],
.ui-tour > .checkout .main .step select {
    height: 40px;
}
.ui-tour > .checkout .main .step textarea {
    max-width: 100%;
    min-height: 40px;
}
.ui-tour > .checkout .main .step input[type=text]:focus,
.ui-tour > .checkout .main .step select:focus,
.ui-tour > .checkout .main .step textarea:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
}
.ui-tour > .checkout .main .step textarea::-webkit-input-placeholder {
    font-style: italic;
    font-size: 12px;
}
.ui-tour > .checkout .main .step textarea:-moz-placeholder {
    font-style: italic;
    font-size: 12px;
}
.ui-tour > .checkout .main .step textarea::-moz-placeholder {
    font-style: italic;
    font-size: 12px;
}
.ui-tour > .checkout .main .step textarea:-ms-input-placeholder {
    font-style: italic;
    font-size: 12px;
}
.ui-tour > .checkout .main .step .section .payments .row {
    margin-bottom: 40px;
}
.ui-tour > .checkout .main .step .section .payments .row:last-child {
    margin-bottom: 17px;
}
.ui-tour > .checkout .main .step .section .payments .payment-name {
    font-size: 13px;
    font-weight: 500;
    font-family: 'Gotham 4r', sans-serif;
    margin-left: 8px;
    color: #000;
}
.ui-tour > .checkout .main .step .section .payments a.whatis {
    font-size: 11.5px;
    font-weight: 400;
    font-family: 'Gotham 4r', sans-serif;
    margin-left: 10px;
    font-style: italic;
}
.ui-tour > .checkout .main .step .section .payments .payment-images {
    position: relative;
    width: 100%;
    margin-top: 7px;
}
.ui-tour > .checkout .main .step .section .payments .payment-images img {
    max-width: 100%;
    display: inline-block;
    margin-bottom: 5px;
}
.ui-tour > .checkout .main .step .section .payments .payment-detail {
    position: relative;
    width: 100%;
    margin-top: 6px;
    font-size: 12.5px;
}
.ui-tour > .checkout .main .step .section .payments .thaibanks {
    position: relative;
    float: left;
}
.ui-tour > .checkout .main .step .section .payments .thaibanks .bank-image {
    position: relative;
    float: left;
    margin-right: 5px;
    width: 50px;
    padding: 7px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.ui-tour > .checkout .main .step .section .payments .thaibanks .bank-image img {
    width: 100%;
}
.ui-tour > .checkout .main .step .section .payments .thaibanks ._note {
    position: relative;
    float: left;
    width: 100%;
    margin-top: 11px;
}
.ui-tour > .checkout .main .step .section .payments .thaibanks ._note em {
    font-size: 12px;
}

.ui-tour .randoms {
    position: relative;
    margin-top: 50px;
    border-top: 1px solid rgb(221, 221, 221);
    padding-top: 20px;
}
.ui-tour .randoms .headline {
    position: absolute;
    top: -11px;
    text-align: center;
    width: 100%;
}
.ui-tour .randoms .headline span {
    font-size: 13.5px;
    font-family: 'Gotham 4r', sans-serif;
    padding: 0px 18px;
    color: #000;
    background-color: rgb(249, 249, 249);
}
.ui-tour .randoms .item {
    position: relative;
    display: block;
    margin-bottom: 25px;
}
.ui-tour .randoms .item .images {
    position: relative;
    display: block;
    border: 1px solid #fff;
    overflow: hidden;
}
.ui-tour .randoms .item .images a {
    display: block;
}
.ui-tour .randoms .item .images a img {
    display: block;
    width: 100%;
}
.ui-tour .randoms .item .images a img.transition {
    transition: all .5s ease-in-out;
}
.ui-tour .randoms .item .images a:hover img.transition {
    transform: scale(1.15);
}
.ui-tour .randoms .item .images a .description {
    position: absolute;
    left: 0px;
    bottom: 0px;
    width: 100%;
    background-attachment: scroll;
    background-size: auto;
    background-image: url('/static/images/tour-description.png');
    background-origin: padding-box;
    background-clip: border-box;
    background-position: bottom;
    background-repeat: repeat-x;
    padding: 10px 12px 0px 12px;
}
.ui-tour .randoms .item .images a .description .price {
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    display: block;
    float: left;
    margin-bottom: 7px;
}
.ui-tour .randoms .item .images a .description .price .amount {
    font-size: 19px;
    display: block;
}
.ui-tour .randoms .item .images a .description .price .type {
    font-size: 13px;
    display: block;
}
.ui-tour .randoms .item .images a .description .contact {
    color: #fff;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    display: block;
    float: right;
    margin-bottom: 7px;
}
.ui-tour .randoms .item .images .previews {
    display: block;
    position: absolute;
    bottom: 10px;
    right: 12px;
}
.ui-tour .randoms .item .images .previews a {
    position: relative;
    display: block;
}
.ui-tour .randoms .item .images .previews a i {
    color: #fff;
    font-size: 18.5px;
}
.ui-tour .randoms .item .info {
    position: relative;
    display: block;
    padding: 8px 2px 12px 2px;
}
.ui-tour .randoms .item .info .title {
    font-size: 15px;
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    line-height: 21px;
}

.ui-tour-checkout-success p {
    font-weight: 400;
    font-family: 'Gotham 3r', sans-serif;
    font-size: 13.5px;
    color: #333;
}
.ui-tour-checkout-success .confirm {
    font-family: 'Gotham 3r', sans-serif;
    font-size: 14px;
    padding: 9px 17px;
}
