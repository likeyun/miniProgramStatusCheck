# miniProgramStatusCheck
微信小程序状态检测（违规、暂停服务、维护中、正在修复）

# 实现原理
进入那些状态不正常的小程序会被重定向至一个Url，使用抓包软件抓取这个Url，剔除不必要参数，使用cURl函数请求网页获得HTML内容，根据内容解析出当前APPID的小程序的状态。<br>

<img src="http://p19.qhimg.com/t013f33cab4393aec21.jpg" />

# 使用
1. 上传miniProgramStatusCheck.php至服务器；<br/>
2. 访问：<br/>
https://域名/miniProgramStatusCheck.php?appid=被检测的小程序的APPID
