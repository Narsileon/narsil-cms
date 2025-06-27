import { ScrollArea } from "@/components/ui/scroll-area";
import { Separator } from "@/components/ui/separator";
import { SettingsIcon, UserIcon } from "lucide-react";
import { TabsList, Tabs, TabsTrigger } from "@/components/ui/tabs";
import { useMinMd } from "@/hooks/use-breakpoints";
import UserSettingsAccount from "./user-settings-account";
import UserSettingsPersonalization from "./user-settings-personalization";
import UserSettingsSecurity from "./user-settings-security";
import useTranslationsStore from "@/stores/translations-store";
import {
  Dialog,
  DialogCloseButton,
  DialogContent,
} from "@/components/ui/dialog";
import type { DialogProps } from "@/components/ui/dialog";

type UserSettingsProps = {
  open: DialogProps["open"];
  onOpenChange: DialogProps["onOpenChange"];
};

function UserSettings({ open, onOpenChange }: UserSettingsProps) {
  const { trans } = useTranslationsStore();

  const minMd = useMinMd();

  return (
    <>
      <Dialog open={open} onOpenChange={onOpenChange}>
        <DialogContent
          className="h-3/4 sm:h-1/2 md:p-0"
          showCloseButton={false}
        >
          <Tabs
            className="h-full overflow-hidden"
            defaultValue="account"
            orientation={minMd ? "vertical" : "horizontal"}
          >
            <TabsList className="md:border-r">
              {minMd ? (
                <DialogCloseButton className="h-12 pl-2 [&_svg:not([class*='size-'])]:size-5" />
              ) : null}
              <TabsTrigger value="account">
                <UserIcon />
                {trans("ui.account")}
              </TabsTrigger>
              <TabsTrigger value="personalization">
                <SettingsIcon />
                {trans("ui.personalization")}
              </TabsTrigger>

              <TabsTrigger value="security">
                <UserIcon />
                {trans("ui.security")}
              </TabsTrigger>
            </TabsList>
            <Separator orientation={minMd ? "vertical" : "horizontal"} />
            <ScrollArea className="h-full w-full">
              <UserSettingsAccount />
              <UserSettingsPersonalization />
              <UserSettingsSecurity />
            </ScrollArea>
          </Tabs>
        </DialogContent>
      </Dialog>
    </>
  );
}

export default UserSettings;
