import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { DynamicIcon } from "lucide-react/dynamic";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import useTranslationsStore from "@/stores/translations-store";
import type { NavigationOption } from "@/types/global";

type SettingsProps = {
  content: NavigationOption[];
};

function Settings({ content }: SettingsProps) {
  const { trans } = useTranslationsStore();

  return (
    <Container className="gap-0" variant="centered">
      {content.map((card, index) => (
        <Card
          className="not-first:rounded-t-none not-last:rounded-b-none"
          key={index}
        >
          <CardHeader>
            <CardTitle>{trans(card.label, card.label)}</CardTitle>
          </CardHeader>
          <CardContent>
            {card.children?.map((child, index) => (
              <Button
                className="h-32 w-32 flex-col"
                variant="ghost"
                key={index}
              >
                <Link href={route(child.route)}>
                  <DynamicIcon className="size-16" name={child.icon} />
                </Link>
                {trans(child.label, child.label)}
              </Button>
            ))}
          </CardContent>
        </Card>
      ))}
    </Container>
  );
}

export default Settings;
