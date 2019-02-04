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
            //long start = System.currentTimeMillis();
            InputStream input  = this.clientSocket.getInputStream();
            OutputStream output = this.clientSocket.getOutputStream();

//            BufferedReader inm = new BufferedReader(new InputStreamReader(input));
//            PrintWriter out = new PrintWriter(output, true /* autoFlush */);

            byte[] receivedData = new byte[8192];
            bis = new BufferedInputStream(clientSocket.getInputStream());
            while ((num = this.bis.read(receivedData)) != -1){
                long time = System.currentTimeMillis();
                String newfile = ("/mnt/share/"+time+".xml");


                //write the data
                if(wat == true) {
                	this.strFileContents += new String(receivedData, 0, num);
                	writeToFile.write(newfile,this.strFileContents,this.bos);
                	this.strFileContents = "";
                	wat = false;
                }
                else {
                	this.strFileContents2 += new String(receivedData, 0, num);
                	writeToFile.write(newfile,this.strFileContents2,this.bos);
                	this.strFileContents2 = "";
                	wat = true;
                }
                //System.out.println(newfile);
            }

            //out.println("File received ");
            input.close();
            output.close();

            System.out.println("File received ");
            //bos.close();
            bis.close();
        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }

    }


}
