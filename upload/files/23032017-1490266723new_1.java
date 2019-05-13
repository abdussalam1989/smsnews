1 log4j
2 Generate Graph
3 exe integration with output file
4 overall testing
5 open output page based on open project id
6 open project


 install4j 
 or 
 exe4j.
 

public static String execCmd(String cmd) throws java.io.IOException {
        Process proc = Runtime.getRuntime().exec(cmd);
        java.io.InputStream is = proc.getInputStream();
        java.util.Scanner s = new java.util.Scanner(is).useDelimiter("\\A");
        String val = "";
        if (s.hasNext()) {
            val = s.next();
        }
        else {
            val = "";
        }
        return val;
}