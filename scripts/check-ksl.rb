#!/usr/bin/ruby
require 'nokogiri'
require 'rubygems'
require 'net/http'
require 'mysql'
require 'net/smtp'


def main
  if ARGV[0] == "test"
    url = "http://www.jqt3of5.com:8080/app/";
    database_url = "localhost";
    database = "kslnotify_test";
    username = "kslnotify_test";
    password = "password";
    from_email_addr = "noreply@jqt3of5.com"
  elsif ARGV[0] == "prod"
    url = "http://www.jqt3of5.com/kslnotify/";
    database_url = "localhost";
    database = "kslnotify";
    username = "kslnotify";
    password = "2Qe4g6F@ui45";
    from_email_addr = "noreply@jqt3of5.com"
  else
    puts "please enter either test or prod"
    exit
  end


  con = Mysql::real_connect(database_url, username, password, nil, 0, nil, 0);
  con.select_db(database)
  
  result = con.query("SELECT * FROM notifications");

  for i in 0..result.num_rows()-1
    row = result.fetch_hash()

    #TODO
    #if row['created'] + 30 < now then
    # deleteAndNotify(con, row['guid'], "Expired")
    #then
    uri = URI.parse(row['url'])
    if uri.host != "www.ksl.com" && uri.host != "ksl.com" then
      deleteAndNotify(con, row, "Invalid host")
      next
    end

    begin
      response = Net::HTTP.get(uri)
    rescue Timeout::Error, Errno::EINVAL, Errno::ECONNRESET, EOFError,
       Net::HTTPBadResponse, Net::HTTPHeaderSyntaxError, Net::ProtocolError => e
      puts e
      deleteAndNotify(con, row, "An exception occured while trying to connect" )
      next
    end

    kslPage = Nokogiri::HTML(response)
    newAds = Array.new
    ads = kslPage.css("div.adBox")
    ads.each {|ad|
      title = ad.css("span.adTitle a.listlink").first.content
      desc = ad.css("div.adDesc").first.content
      price = ad.css("div.priceBox span").first.content
      image_url = ad.css("div.adImage a img").first["src"]
      ad_url = ad.css("div.adImage a").first["href"]
      
      ads_result = con.query("SELECT * from ads WHERE guid='#{row['guid']}' AND adUrl='#{ad_url}'")
      if (ads_result.num_rows == 0) then
        newAds.push([title, desc, price, image_url, ad_url])
        con.query("INSERT INTO ads (guid, title, description, price, imgurl, adurl) VALUES ('#{row['guid']}', '#{title}', '#{desc}', '#{price}', '#{image_url}', '#{ad_url}')")
      end
    }
 
    email = <<END
From:<noreply@jqt3of5.com>
Content-Type: text/html; charset="ISO-8859-1";
To:<#{row['email']}>
Subject:#{row['name']}
There are new ads for you to look at! <br><br>
#{ads}                         
<a href="#{row['url']}">Click here to see them all</a><br>
If you would like to be removed from the mailing list, <a href="${url}/removeNotification.php?guid=#{row['guid']}">Click here.</a>
END

puts email
    Net::SMTP.start('localhost', 25) do |smtp|
#      smtp.send_message email_message, from_email_addr, row['email']
    end
  end
end

def deleteAndNotify(con, row, reason)
  
  puts "Deleteing #{row} because: #{reason}"
  #TODO: send email
  con.query("DELETE FROM notifications WHERE guid='#{row['guid']}'");
end


main
