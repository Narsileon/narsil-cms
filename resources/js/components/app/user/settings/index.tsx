import { Separator } from "@/components/ui/separator";
import { SettingsIcon, UserIcon } from "lucide-react";
import { TabsList, Tabs, TabsTrigger } from "@/components/ui/tabs";
import { useMinMd } from "@/hooks/use-breakpoints";
import { useTranslationsStore } from "@/stores/translations-store";
import UserSettingsAccount from "./user-settings-account";
import UserSettingsPersonalization from "./user-settings-personalization";
import UserSettingsSecurity from "./user-settings-security";
import {
  Dialog,
  DialogCloseButton,
  DialogContent,
  DialogProps,
} from "@/components/ui/dialog";

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
        <DialogContent className="md:p-0" showCloseButton={false}>
          <Tabs
            defaultValue="general"
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
            <UserSettingsAccount />
            <UserSettingsPersonalization />
            <UserSettingsSecurity />
          </Tabs>
        </DialogContent>
      </Dialog>
    </>
  );
}

export default UserSettings;
