import { Button } from "@/components/ui/button";
import { DialogClose } from "@/components/ui/dialog";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { Separator } from "@/components/ui/separator";
import TwoFactorForm from "./two-factor-form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type SecurityFormProps = {
  labels: {
    security: string;
    sessions: string;
    sign_out_current_description: string;
    sign_out_current: string;
    sign_out_elsewhere_description: string;
    sign_out_elsewhere: string;
    sign_out_everywhere_description: string;
    sign_out_everywhere: string;
  };
  twoFactorForm: LaravelForm;
};

function SecurityForm({ labels, twoFactorForm }: SecurityFormProps) {
  return (
    <>
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">
            {labels.security ?? "Security"}
          </SectionTitle>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">
            {labels.sessions ?? "Sessions"}
          </SectionTitle>
        </SectionHeader>
        <SectionContent className="grid gap-4 text-sm">
          <p>
            {labels.sign_out_current_description ?? "Sign out of this device."}
          </p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "current",
                })}
              >
                {labels.sign_out_current ?? "Sign out"}
              </Link>
            </Button>
          </DialogClose>
          <Separator />
          <p>
            {labels.sign_out_elsewhere_description ??
              "Sign out of all devices, excluding this one."}
          </p>
          <Button asChild={true} variant="outline">
            <Link
              method="delete"
              href={route("sessions.delete", {
                type: "others",
              })}
              preserveState={true}
            >
              {labels.sign_out_elsewhere ?? "Sign out elsewhere"}
            </Link>
          </Button>
          <Separator />
          <p>
            {labels.sign_out_everywhere_description ??
              "Sign out of all devices, including this one."}
          </p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "all",
                })}
              >
                {labels.sign_out_everywhere ?? "Sign out everywhere"}
              </Link>
            </Button>
          </DialogClose>
        </SectionContent>
      </Section>
    </>
  );
}

export default SecurityForm;
