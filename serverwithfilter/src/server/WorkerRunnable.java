package server;

import java.io.*;
import java.net.Socket;
import java.util.*;

public class WorkerRunnable implements Runnable{

    protected Socket clientSocket = null;
    protected String serverText   = null;
    int num = 3343;
    BufferedInputStream bis;
    BufferedOutputStream bos;
    String strFileContents = "";


    public WorkerRunnable(Socket clientSocket, String serverText) {
        this.clientSocket = clientSocket;
        this.serverText   = serverText;
    }

    public void run() {
        try {
            //long start = System.currentTimeMillis();
            InputStream input  = this.clientSocket.getInputStream();
            OutputStream output = this.clientSocket.getOutputStream();

            BufferedReader inm = new BufferedReader(new InputStreamReader(input));
            PrintWriter out = new PrintWriter(output, true /* autoFlush */);

            byte[] receivedData = new byte[8192];
            bis = new BufferedInputStream(clientSocket.getInputStream());
            while ((num = bis.read(receivedData)) != -1){
                long time = System.currentTimeMillis();
                String newfile = (time + ".xml");

                this.strFileContents += new String(receivedData,0,num);
                //System.out.println(strFileContents + "hier naar kijken");
                //write the data
                writeToFile.write(newfile,this.strFileContents,bos);

                //this.strFileContents = "";

                //System.out.println(newfile);
            }

            System.out.println("File received ");
            //bos.close();
            bis.close();
        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }
    }


}