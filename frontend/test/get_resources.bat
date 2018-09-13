mkdir drivers
wget http://selenium.googlecode.com/files/selenium-server-standalone-2.35.0.jar
mv selenium-server-standalone-2.35.0.jar drivers/selenium-server.jar

wget http://chromedriver.googlecode.com/files/chromedriver_win32_2.2.zip
unzip chromedriver_win32_2.2.zip
mv chromedriver.exe drivers/
rm chromedriver_win32_2.2.zip

wget http://selenium.googlecode.com/files/IEDriverServer_Win32_2.35.3.zip
unzip IEDriverServer_Win32_2.35.3.zip
mv IEDriverServer.exe drivers/
rm IEDriverServer_Win32_2.35.3.zip
