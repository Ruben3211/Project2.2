package server;

import java.net.ServerSocket;
import java.net.Socket;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;


public class MultiThreadedServer implements Runnable{

    protected int          serverPort   = 3333;
    protected ServerSocket serverSocket = null;
    protected boolean      isStopped    = false;
    protected Thread       runningThread= null;
    public static int      filenumber   = 0;
    public static List<String> bufferForFile = Collections.synchronizedList(new ArrayList<String>());
    ExecutorService exser = Executors.newFixedThreadPool(400);


    static ArrayList<Integer> arl = new ArrayList<Integer>();

    public MultiThreadedServer(int port){
        this.serverPort = port;
    }

    public synchronized void run(){
        arl.addAll(Arrays.asList(70020, 70030, 70050, 70100, 70150, 70170, 70200, 70240, 70270, 70280, 70290, 70310, 70370, 70380, 70400, 70460, 70550, 70570, 70610, 70700, 70750, 70881, 70891, 70900, 70930, 71000, 71030, 71060, 71070, 71090, 71100, 71170, 71180, 71190, 71200, 71210, 71250, 71270, 71300, 71330, 71390, 71400, 71430, 71450, 71460, 71470, 71490, 71500, 71530, 71560, 71570, 71650, 71680, 71690, 71790, 71800, 71810, 71860, 71900, 71970, 72000, 72010, 72050, 72070, 72170, 72220, 72300, 72350, 72400, 72490, 72550, 72553, 72554, 72570, 72600, 72650, 72700, 72800, 72830, 72880, 72920, 72950, 72990, 73000, 73060, 73140, 73150, 73160, 73175, 73300, 73350, 73540, 73740, 73790, 73850, 73860, 73901, 74000, 74120, 74340, 74380, 74600, 74700, 74710, 74750, 74760, 74800, 74810, 74820, 74860, 74910, 74940, 74970, 75000, 75020, 75030, 75100, 75240, 75300, 75350, 75400, 75490, 75520, 75580, 75630, 75770, 75790, 75880, 75910, 76000, 76020, 76030, 76070, 76100, 76210, 76220, 76270, 76300, 76310, 76320, 76350, 76380, 76410, 76415, 76430, 76450, 76460, 76470, 76500, 76520, 76530, 76600, 76610, 76670, 76700, 76840, 76900, 76950, 77470, 77490, 77530, 77540, 77560, 77610, 77650, 77680, 77700, 77800, 77850, 77900, 77910));
        synchronized(this){

            this.runningThread = Thread.currentThread();
        }
        openServerSocket();
        System.out.println("Server Started");
        while(! isStopped()){
            Socket clientSocket = null;
            try {
                clientSocket = this.serverSocket.accept();
            } catch (IOException e) {
                if(isStopped()) {
                    System.out.println("Server Stopped.") ;
                    return;
                }
                throw new RuntimeException(
                        "Error accepting client connection", e);
            }
            this.exser.execute(
            (
                    new WorkerRunnable(
                            clientSocket, "Multithreaded Server")
            ));
        }

    }


    private synchronized boolean isStopped() {
        return this.isStopped;
    }

    private void openServerSocket() {
        try {
            this.serverSocket = new ServerSocket(this.serverPort);
        } catch (IOException e) {
            throw new RuntimeException("Cannot open port 3333", e);
        }
    }
    public synchronized static boolean checkarray(String reqstr){
       if (arl.contains(Integer.parseInt(reqstr))){
        return true;
       } else {
        return false;
       }
    }


}
