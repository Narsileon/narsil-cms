import { ScrollArea } from "@/components/ui/scroll-area";
import { Separator } from "@/components/ui/separator";
import { SettingsIcon, ShieldCheckIcon, UserPenIcon } from "lucide-react";
import { TabsList, Tabs, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { useAuth } from "@/hooks/use-props";
import { useLabels } from "@/components/ui/labels";
import { useMinMd } from "@/hooks/use-breakpoints";
import ConfigurationForm from "@/components/app/user/configuration-form";
import ProfileForm from "@/components/app/user/profile-form";
import SecurityForm from "@/components/app/user/security-form";
import type { LaravelForm } from "@/types";

type UserSettingsProps = {
  profileForm: LaravelForm;
  twoFactorForm: LaravelForm;
  updatePasswordForm: LaravelForm;
  userConfigurationForm: LaravelForm;
};

function UserSettings({
  profileForm,
  twoFactorForm,
  updatePasswordForm,
  userConfigurationForm,
}: UserSettingsProps) {
  const { getLabel } = useLabels();

  const auth = useAuth();
  const minMd = useMinMd();

  return (
    <Tabs
      className="h-full overflow-hidden"
      defaultValue={auth ? "account" : "configuration"}
      orientation="vertical"
    >
      <TabsList className="md:border-r">
        {auth ? (
          <TabsTrigger value="account">
            <UserPenIcon />
            {getLabel("ui.account")}
          </TabsTrigger>
        ) : null}
        <TabsTrigger value="configuration">
          <SettingsIcon />
          {getLabel("ui.personalization")}
        </TabsTrigger>
        {auth ? (
          <TabsTrigger value="security">
            <ShieldCheckIcon />
            {getLabel("ui.security")}
          </TabsTrigger>
        ) : null}
      </TabsList>
      <Separator orientation={minMd ? "vertical" : "horizontal"} />
      <ScrollArea className="h-full w-full">
        {auth ? (
          <TabsContent value="account">
            <ProfileForm
              profileForm={profileForm}
              updatePasswordForm={updatePasswordForm}
            />
          </TabsContent>
        ) : null}

        <TabsContent value="configuration">
          <ConfigurationForm form={userConfigurationForm} />
        </TabsContent>
        {auth ? (
          <TabsContent value="security">
            <SecurityForm twoFactorForm={twoFactorForm} />
          </TabsContent>
        ) : null}
      </ScrollArea>
    </Tabs>
  );
}

export default UserSettings;
