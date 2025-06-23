import { Button } from "@/components/ui/button";
import { DialogClose } from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import { Link } from "@inertiajs/react";
import { Separator } from "@/components/ui/separator";
import { TabsContent } from "@/components/ui/tabs";
import { useRoute } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

function UserSettingsSecurity() {
  const route = useRoute();

  const { trans } = useTranslationsStore();

  return (
    <TabsContent value="security">
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.security")}</SectionTitle>
        </SectionHeader>
        <SectionContent className="grid gap-2">
          <div className="flex items-center justify-between">
            <Label>{trans("Log out of this device.")}</Label>
            <DialogClose asChild={true}>
              <Button asChild={true} variant="outline">
                <Link
                  method="delete"
                  href={route("sessions.delete", {
                    type: "current",
                  })}
                >
                  {trans("ui.log_out")}
                </Link>
              </Button>
            </DialogClose>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <Label>{trans("Log out of others devices.")}</Label>
            <DialogClose>
              <Button asChild={true} variant="outline">
                <Link
                  method="delete"
                  href={route("sessions.delete", {
                    type: "others",
                  })}
                >
                  {trans("ui.log_out_others")}
                </Link>
              </Button>
            </DialogClose>
          </div>
          <Separator />
          <div className="flex items-center justify-between">
            <Label>{trans("Log out of all devices.")}</Label>
            <DialogClose>
              <Button asChild={true} variant="outline">
                <Link
                  method="delete"
                  href={route("sessions.delete", {
                    type: "all",
                  })}
                >
                  {trans("ui.log_out_all")}
                </Link>
              </Button>
            </DialogClose>
          </div>
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsSecurity;
