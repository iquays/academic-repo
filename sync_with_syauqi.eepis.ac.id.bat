REM batch program to synchronize simas on local and simas on W2008 Server
@Echo Off

robocopy.exe _protected "Y:\wwwroot\c203.pens.ac.id\mk\_protected" /MIR /R:1 /W:2 /TEE /XD D:\!wwwroot\mk\_protected\runtime\debug
robocopy.exe images "Y:\wwwroot\c203.pens.ac.id\mk\images" /MIR /R:1 /W:2 /TEE
robocopy.exe uploads "Y:\wwwroot\c203.pens.ac.id\mk\uploads" /MIR /R:1 /W:2 /TEE

robocopy.exe _protected "Y:\wwwroot\www\mk\_protected" /MIR /R:1 /W:2 /TEE /XD D:\!wwwroot\mk\_protected\runtime\debug
robocopy.exe images "Y:\wwwroot\www\mk\images" /MIR /R:1 /W:2 /TEE
robocopy.exe uploads "Y:\wwwroot\www\mk\uploads" /MIR /R:1 /W:2 /TEE