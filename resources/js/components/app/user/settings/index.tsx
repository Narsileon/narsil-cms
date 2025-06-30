import { ScrollArea } from "@/components/ui/scroll-area";
import { Separator } from "@/components/ui/separator";
import { SettingsIcon, ShieldCheckIcon, UserPenIcon } from "lucide-react";
import { TabsList, Tabs, TabsTrigger } from "@/components/ui/tabs";
import { useMinMd } from "@/hooks/use-breakpoints";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useAuth from "@/hooks/use-auth";
import UserSettingsAccount from "./user-settings-account";
import UserSettingsPersonalization from "./user-settings-personalization";
import UserSettingsSecurity from "./user-settings-security";
import useTranslationsStore from "@/stores/translations-store";
import {
  Dialog,
  DialogCloseButton,
  DialogContent,
  DialogTitle,
} from "@/components/ui/dialog";
import type { DialogProps } from "@/components/ui/dialog";

type UserSettingsProps = {
  open: DialogProps["open"];
  onOpenChange: DialogProps["onOpenChange"];
};

function UserSettings({ open, onOpenChange }: UserSettingsProps) {
  const { trans } = useTranslationsStore();

  const auth = useAuth();

  const minMd = useMinMd();

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <VisuallyHidden>
        <DialogTitle>
          {trans("accessibility.user_settings", "User settings")}
        </DialogTitle>
      </VisuallyHidden>
      <DialogContent className="h-3/4 sm:h-1/2 md:p-0" showCloseButton={false}>
        <Tabs
          className="h-full overflow-hidden"
          defaultValue="account"
          orientation={minMd ? "vertical" : "horizontal"}
        >
          <TabsList className="md:border-r">
            {minMd ? (
              <DialogCloseButton className="h-12 w-12 pl-2 [&_svg:not([class*='size-'])]:size-5" />
            ) : null}
            {auth ? (
              <TabsTrigger value="account">
                <UserPenIcon />
                {trans("ui.account", "Account")}
              </TabsTrigger>
            ) : null}
            <TabsTrigger value="personalization">
              <SettingsIcon />
              {trans("ui.personalization", "Personalization")}
            </TabsTrigger>
            {auth ? (
              <TabsTrigger value="security">
                <ShieldCheckIcon />
                {trans("ui.security", "Security")}
              </TabsTrigger>
            ) : null}
          </TabsList>
          <Separator orientation={minMd ? "vertical" : "horizontal"} />
          <ScrollArea className="h-full w-full">
            {auth ? <UserSettingsAccount /> : null}
            <UserSettingsPersonalization />
            {auth ? <UserSettingsSecurity /> : null}
          </ScrollArea>
        </Tabs>
      </DialogContent>
    </Dialog>
  );
}

export default UserSettings;
