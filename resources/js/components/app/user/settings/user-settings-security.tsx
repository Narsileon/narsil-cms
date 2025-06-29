import { Button } from "@/components/ui/button";
import { DialogClose } from "@/components/ui/dialog";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { Separator } from "@/components/ui/separator";
import { TabsContent } from "@/components/ui/tabs";
import UserSettingsSecurityTwoFactor from "./user-settings-security-two-factor";
import useTranslationsStore from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

function UserSettingsSecurity() {
  const { trans } = useTranslationsStore();

  return (
    <TabsContent value="security">
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">
            {trans("ui.security", "Security")}
          </SectionTitle>
        </SectionHeader>
        <SectionContent>
          <UserSettingsSecurityTwoFactor />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">
            {trans("ui.sessions", "Sessions")}
          </SectionTitle>
        </SectionHeader>
        <SectionContent className="grid gap-4 text-sm">
          <p>
            {trans(
              "sessions.sign_out.current.description",
              "Sign out of this device.",
            )}
          </p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "current",
                })}
              >
                {trans("sessions.sign_out.current.button", "Sign out")}
              </Link>
            </Button>
          </DialogClose>
          <Separator />
          <p>
            {trans(
              "sessions.sign_out.others.description",
              "Sign out of all devices, excluding this one.",
            )}
          </p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "others",
                })}
              >
                {trans("sessions.sign_out.others.button", "Sign out elsewhere")}
              </Link>
            </Button>
          </DialogClose>
          <Separator />
          <p>
            {trans(
              "sessions.sign_out.all.description",
              "Sign out of all devices, including this one.",
            )}
          </p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "all",
                })}
              >
                {trans("sessions.sign_out.all.button", "Sign out everywhere")}
              </Link>
            </Button>
          </DialogClose>
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsSecurity;
