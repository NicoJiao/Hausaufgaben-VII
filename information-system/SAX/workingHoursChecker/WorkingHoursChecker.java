import java.util.Stack;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

/**
 * @author Haoze Zhang
 * @version 24-11-2016
 * Class WorkingHoursChecker, extends DefaultHandler, provides call back functions
 * to calculate: average working hour, worker's last name of whom works more than 40 h/wk
 */
public class WorkingHoursChecker extends DefaultHandler {
  int hoursTotals = 0;
  int numberOfEmps = 0;
  boolean takeHour = false;
  boolean takeName = false;
  Stack<String> lastNames = new Stack<String>();

/* (non-Javadoc)
* @see org.xml.sax.helpers.DefaultHandler#startDocument()
* Print the introduction
*/
@Override
public void startDocument( ) throws SAXException {
	  System.out.println("Parsing Starts!");
	  System.out.println("Calculating average working hour/week");
	  System.out.println("And poor guys who work more than 40 hours/week");
  }

/* (non-Javadoc)
* @see org.xml.sax.helpers.DefaultHandler#endDocument()
* Print the results
*/
@Override
public void endDocument( ) throws SAXException {
	  if (numberOfEmps == 0) {
		  System.out.println("No employee!");
		  return;
	  }
	  System.out.println("Result:");
	  System.out.println("Average working hour is " + hoursTotals / numberOfEmps + " hours/week");
	  System.out.println("These people work 40+ hours per week:");
	  for (String ln: lastNames) {
		  System.out.println(ln);
	  }
  }


/* (non-Javadoc)
* @see org.xml.sax.helpers.DefaultHandler#startElement(java.lang.String, java.lang.String, java.lang.String, org.xml.sax.Attributes)
* Check element type and get ready for taking in characters
*/
@Override
public void startElement(String namespaceURI, String localName,
                           String qName, Attributes attr )
  throws SAXException {
	  if (localName.equals("employee")) {
		  numberOfEmps++;
	  }
	  if (localName.equals("hoursPerWeek")) {
		  takeHour = true;
	  }
	  if (localName.equals("lastName")) {
		  takeName = true;
	  }
  }

/* (non-Javadoc)
* @see org.xml.sax.helpers.DefaultHandler#endElement(java.lang.String, java.lang.String, java.lang.String)
* Left empty
*/
@Override
public void endElement(String namespaceURI, String localName,
                         String qName ) throws SAXException {
	// empty
  }

/* (non-Javadoc)
* @see org.xml.sax.helpers.DefaultHandler#characters(char[], int, int)
* Take characters of either hour of work, or last name of the worker
*/
@Override
public void characters(char[] ch, int start, int length )
  throws SAXException {
	  if (takeHour) { // inner characters in hoursPerWeek element
		  String hoursString = new String(ch, start, length);
		  hoursString = hoursString.trim();
		  int hours = new Integer(hoursString);
		  hoursTotals += hours;
		  if (hours <= 40) { // discard invalid (work no more than 40 hrs) name
			  lastNames.pop();
		  }
		  takeHour = false;
	  }
	  if (takeName) { // inner characters in lastName element
		  String nameString = new String(ch, start, length);
		  lastNames.add(nameString);
		  takeName = false;
	  }
  }
}
