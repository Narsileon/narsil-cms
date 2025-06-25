import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

function Settings() {
  return (
    <div className="flex flex-col">
      <Card className="rounded-b-none">
        <CardHeader>
          <CardTitle>System</CardTitle>
        </CardHeader>
        <CardContent>
          <Button asChild>
            <Link href={route("sites.index")}></Link>
          </Button>
        </CardContent>
      </Card>
      <Card className="rounded-t-none">
        <CardHeader>
          <CardTitle>Content</CardTitle>
          <CardContent></CardContent>
        </CardHeader>
      </Card>
    </div>
  );
}

export default Settings;
