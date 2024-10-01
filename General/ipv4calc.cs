using System;
using System.Linq;

class IPCalculator
{
    private int[] _address;
    private int _cidr;

    public IPCalculator(string ipAddress)
    {
        var parts = ipAddress.Contains("/") ? ipAddress.Split('/') : new[] { ipAddress, "24" };
        _address = parts[0].Split('.').Select(int.Parse).ToArray();  // Rozdělí IP na části a převede na čísla
        _cidr = int.Parse(parts[1]);  // Nastaví CIDR
    }

    public void DisplayResult()
    {
        var netMask = GetNetMask();
        var networkIP = GetNetworkIP(netMask);
        var broadcastIP = GetBroadcastIP(netMask);

        Console.WriteLine($"IP Address: {string.Join(".", _address)}/{_cidr}");
        Console.WriteLine($"Netmask: {string.Join(".", netMask)}");
        Console.WriteLine($"Network ID: {string.Join(".", networkIP)}");
        Console.WriteLine($"Broadcast IP: {string.Join(".", broadcastIP)}");
        Console.WriteLine($"Host Range: {string.Join(".", Increment(networkIP))} - {string.Join(".", Decrement(broadcastIP))}");
        Console.WriteLine($"Max Hosts: {Math.Pow(2, 32 - _cidr) - 2}");  // Výpočet max. počtu hostů
    }

    private int[] GetNetMask()
    {
        // Vytvoří masku sítě podle CIDR (např. 255.255.255.0)
        return Enumerable.Range(0, 4).Select(i => i < _cidr / 8 ? 255 : (i == _cidr / 8 ? 256 - (1 << (8 - _cidr % 8)) : 0)).ToArray();
    }

    private int[] GetNetworkIP(int[] netMask) 
    {
        // Výpočet IP adresy sítě: AND operace mezi IP a maskou
        return _address.Zip(netMask, (a, m) => a & m).ToArray();
    }

    private int[] GetBroadcastIP(int[] netMask) 
    {
        // Výpočet broadcast IP: OR operace mezi IP a negovanou maskou
        return _address.Zip(netMask, (a, m) => a | ~m & 255).ToArray();
    }

    private int[] Increment(int[] ip) 
    {
        // Zvýší poslední část IP o 1 (minimální IP pro hosty)
        ip[3]++;
        return ip;
    }

    private int[] Decrement(int[] ip) 
    {
        // Sníží poslední část IP o 1 (maximální IP pro hosty)
        ip[3]--;
        return ip;
    }
}

class Program
{
    static void Main()
    {
        Console.Write("Enter an IP address (e.g. 192.168.1.1/24) or press Enter for default (192.168.1.1/24): ");
        string ip = Console.ReadLine();

        if (string.IsNullOrWhiteSpace(ip))
        {
            ip = "192.168.1.1/24";
            Console.WriteLine("No input provided. Using default IP address: 192.168.1.1/24");
        }

        new IPCalculator(ip).DisplayResult();  // Spočítá a zobrazí výsledky
    }
}
