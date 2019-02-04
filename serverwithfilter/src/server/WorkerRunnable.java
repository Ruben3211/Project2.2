package server;

import java.io.*;
import java.net.Socket;

public class WorkerRunnable implements Runnable{

    protected Socket clientSocket = null;
    protected String serverText   = null;
    int num = 3343;
    BufferedInputStream bis;
    BufferedOutputStream bos;
    String strFileContents = "";
	String strFileContents2 = "";
	boolean wat = false;


    public WorkerRunnable(Socket clientSocket, String serverText) {
        this.clientSocket = clientSocket;
        this.serverText   = serverText;
    }

    public void run() {
        try {


            byte[] receivedData = new byte[8192];
            bis = new BufferedInputStream(clientSocket.getInputStream(),65536 );
            while ((num = this.bis.read(receivedData)) != -1){
                long time = System.currentTimeMillis();
                String newfile = ("/mnt/share/"+time+".xml");
                //"/mnt/share/"+ for pi

                //write the data
                if(wat == true) {
                	this.strFileContents = new String(receivedData, 0, num);
                	writeToFile.write(newfile,this.strFileContents,this.bos);
                	this.strFileContents = "";
                	wat = false;
                }
                else {
                	this.strFileContents2 = new String(receivedData, 0, num);
                	writeToFile.write(newfile,this.strFileContents2,this.bos);
                	this.strFileContents2 = "";
                	wat = true;
                }
            }
            bis.close();



        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }

    }


}
