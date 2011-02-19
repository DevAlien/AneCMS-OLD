function assertEquals(got, expected, name) {
    if(!name) {
        name = "";
    }

    if(got!==expected) {
        console.log("****FAIL**** "+name+": expected ["+expected+"]("+typeof expected+"), got ["+got+"]("+typeof got+")");
    } else {
        console.log("PASS "+name+": expected ["+expected+"]("+typeof expected+"), got ["+got+"]("+typeof got+")");
    }
}


function runStoreUnitTests() {
    // lovely little unit tests on storage objects
    var testStores = [[cookieStore,"cookieStore"],[localStorageStore,"localStorageStore"],[arrayStore,"arrayStore"]];

    for(i=0 ; i<testStores.length ; i++) {
        console.log("=========="+testStores[i][1]+"===========");

        assertEquals((typeof testStores[i][0]),"function","store is non-instantiated");

        testStores[i][0] = testStores[i][0]();
        var randKeyName = Math.random();
        assertEquals(testStores[i][0].has(randKeyName),false,"has bad val");
        assertEquals(testStores[i][0].get(randKeyName),undefined,"get bad val");
        testStores[i][0].set("foo","bar");
        assertEquals(testStores[i][0].has("foo"),true,"has set val");
        assertEquals(testStores[i][0].get("foo"),"bar","get set val");
        testStores[i][0].kill("foo");
        assertEquals(testStores[i][0].has("foo"),false,"has killed val");
        assertEquals(testStores[i][0].get("foo"),undefined,"get killed val");
        testStores[i][0].set("foo",null);
        assertEquals(testStores[i][0].has("foo"),true,"has set null val");
        assertEquals(testStores[i][0].get("foo"),null,"get set null val");
        testStores[i][0].set("foo","bar");
        //testStores[i][0].set("foo",undefined);
        testStores[i][0].set("foo");
        assertEquals(testStores[i][0].has("foo"),false,"has set undefined val (this should result in the key being killed)");
        assertEquals(testStores[i][0].get("foo"),undefined,"get set undefined val");
    }
}

function runCacheGetSetUnitTests(cache) {

    console.log("==========runCacheGetSetUnitTests===========");

    cache = cache();
    assertEquals(cache.setStore(""),false,"Cannot set store to invalid store");
    assertEquals(cache.setStore(arrayStore),true,"Can set store to arrayStore");

    var randKeyName = Math.random();

    var tomorrow = new Date();
    tomorrow.setTime(tomorrow.getTime() + (1000*3600*24));
    var yesterday = new Date();
    yesterday.setTime(yesterday.getTime() - (1000*3600*24));

    /*
    standard get/set tests
    */
    assertEquals(cache.get(randKeyName),null,"Read value of bad key");
    assertEquals(cache.getExpiry(randKeyName),null,"Read expiry of bad key");

    cache.setExpiry(randKeyName,tomorrow);
    assertEquals(cache.get(randKeyName),null,"Read value of bad key having had expiry set");
    assertEquals(cache.getExpiry(randKeyName),null,"Read expiry of bad key having had expiry set");

    cache.set("infiniteKey","this never expires");
    assertEquals(cache.get("infiniteKey"),"this never expires","Read value of infinite key");
    assertEquals(cache.getExpiry("infiniteKey"),false,"Read expiry of infinite key");

    cache.set("yesterdayKey","this expired yesterday", yesterday);
    assertEquals(cache.get("yesterdayKey"),null,"Read value of expired key");
    assertEquals(cache.getExpiry("yesterdayKey"),null,"Read expiry of expired key");

    cache.set("tomorrowKey","this expires tomorrow", tomorrow);
    assertEquals(cache.get("tomorrowKey"),"this expires tomorrow","Read value of finite key");
    assertEquals(Date.parse(cache.getExpiry("tomorrowKey")),Date.parse(tomorrow),"Read expiry of finite key");
}

function runCacheUpdateUnitTests(cache) {

    console.log("==========runCacheUpdateUnitTests===========");

    cache = cache();
    cache.setStore(arrayStore)

    var tomorrow = new Date();
    tomorrow.setTime(tomorrow.getTime() + (1000*3600*24));
    var day_after_tomorrow = new Date();
    day_after_tomorrow.setTime(tomorrow.getTime() + (1000*3600*24));
    var yesterday = new Date();
    yesterday.setTime(yesterday.getTime() - (1000*3600*24));

    cache.set("infiniteKey","this never expires");
    cache.set("yesterdayKey","this expired yesterday", yesterday);
    cache.set("tomorrowKey","this expires tomorrow", tomorrow);

    cache.set("infiniteKey","new value");
    assertEquals(cache.get("infiniteKey"),"new value","Read value of infinite key, modified using set");
    assertEquals(cache.getExpiry("infiniteKey"),false,"Read expiry of infinite key, modified using set");

    cache.setExpiry("infiniteKey",tomorrow);
    assertEquals(cache.get("infiniteKey"),"new value","Read value of infinite key, modified using setExpiry");
    assertEquals(Date.parse(cache.getExpiry("infiniteKey")),Date.parse(tomorrow),"Read expiry of infinite key, modified using setExpiry");

    cache.setExpiry("infiniteKey",yesterday);
    assertEquals(cache.get("infiniteKey"),null,"Read value of infinite key, modified using setExpiry to be expired");
    assertEquals(cache.getExpiry("infiniteKey"),null,"Read expiry of infinite key, modified using setExpiry to be expired");

    cache.set("tomorrowKey","new value");
    assertEquals(cache.get("tomorrowKey"),"new value","Read value of finite key, modified using set");
    assertEquals(Date.parse(cache.getExpiry("tomorrowKey")),Date.parse(tomorrow),"Read expiry of finite key, modified using set");

    cache.setExpiry("tomorrowKey",day_after_tomorrow);
    assertEquals(cache.get("tomorrowKey"),"new value","Read value of finite key, modified using setExpiry");
    assertEquals(Date.parse(cache.getExpiry("tomorrowKey")),Date.parse(day_after_tomorrow),"Read expiry of finite key, modified using setExpiry");

    cache.setExpiry("tomorrowKey",yesterday);
    assertEquals(cache.get("tomorrowKey"),null,"Read value of finite key, modified using setExpiry to be expired");
    assertEquals(cache.getExpiry("tomorrowKey"),null,"Read expiry of finite key, modified using setExpiry to be expired");

    cache.set("yesterdayKey","new value");
    assertEquals(cache.get("yesterdayKey"),"new value","Read value of previously-expired key, modified using set");
    assertEquals(cache.getExpiry("yesterdayKey"),false,"Read expiry of previously-expired key, modified using set");

    // expire again
    cache.setExpiry("yesterdayKey",yesterday);

    cache.setExpiry("yesterdayKey",tomorrow);
    assertEquals(cache.get("yesterdayKey"),null,"Read value of previously-expired key, modified using setExpiry");
    assertEquals(cache.getExpiry("yesterdayKey"),null,"Read expiry of previously-expired key, modified using setExpiry");

    cache.setExpiry("yesterdayKey",yesterday);
    assertEquals(cache.get("yesterdayKey"),null,"Read value of previously-expired key, modified using setExpiry to be expired");
    assertEquals(cache.getExpiry("yesterdayKey"),null,"Read expiry of previously-expired key, modified using setExpiry to be expired");
}