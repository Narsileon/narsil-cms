import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { GlobeIcon, SquarePenIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import useTranslationsStore from "@/stores/translations-store";

function Settings() {
  const { trans } = useTranslationsStore();

  return (
    <div className="flex flex-col">
      <Card className="rounded-b-none">
        <CardHeader>
          <CardTitle>{trans("ui.system")}</CardTitle>
        </CardHeader>
        <CardContent>
          <Button className="h-32 w-32 flex-col" variant="ghost">
            <Link href={route("sites.index")}>
              <GlobeIcon className="size-16" />
            </Link>
            {trans("ui.sites")}
          </Button>
          <Button className="h-32 w-32 flex-col" variant="ghost">
            <Link href={route("users.index")}>
              <GlobeIcon className="size-16" />
            </Link>
            {trans("ui.users")}
          </Button>
        </CardContent>
      </Card>
      <Card className="rounded-t-none">
        <CardHeader>
          <CardTitle>{trans("ui.content")}</CardTitle>
        </CardHeader>
        <CardContent>
          <Button className="h-32 w-32 flex-col" variant="ghost">
            <Link href={route("sites.index")}>
              <SquarePenIcon className="size-16" />
            </Link>
            {trans("ui.fields")}
          </Button>
        </CardContent>
      </Card>
    </div>
  );
}

export default Settings;
