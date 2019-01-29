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
            InputStream input  = clientSocket.getInputStream();
            OutputStream output = clientSocket.getOutputStream();

            BufferedReader inm = new BufferedReader(new InputStreamReader(input));
            PrintWriter out = new PrintWriter(output, true /* autoFlush */);

            // String strFileContents = "";
            byte[] receivedData = new byte[8192];
            bis = new BufferedInputStream(clientSocket.getInputStream());
            while ((num = bis.read(receivedData)) != -1){
                long time = System.currentTimeMillis();
                String newfile = (time + "-" + MultiThreadedServer.verhoogEnHaalOp() + ".xml");

                // strFileContents += new String(receivedData, 0, num);

                //write the data
                writeToFile.write(receivedData,newfile,strFileContents,num,bos);


                //System.out.println(newfile);
            }
            bis.close();
            out.println("File received ");

        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }
    }


}