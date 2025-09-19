import { route } from "ziggy-js";

import { Button, Heading, Separator } from "@narsil-cms/blocks";
import { DialogClose } from "@narsil-cms/components/dialog";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { type FormType } from "@narsil-cms/types";

import TwoFactorForm from "./two-factor-form";

type SecurityFormProps = {
  twoFactorForm: FormType;
};

function SecurityForm({ twoFactorForm }: SecurityFormProps) {
  const { trans } = useLabels();

  return (
    <>
      <SectionRoot>
        <SectionHeader className="border-b">
          <Heading level="h2">{trans("ui.security")}</Heading>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </SectionRoot>
      <Separator />
      <SectionRoot>
        <SectionHeader className="border-b">
          <Heading level="h2">{trans("ui.sessions")}</Heading>
        </SectionHeader>
        <SectionContent className="grid gap-4">
          <p>{trans("sessions.sign_out_current_description")}</p>
          <DialogClose asChild={true}>
            <Button
              linkProps={{
                href: route("sessions.delete", {
                  type: "current",
                }),
                method: "delete",
              }}
              variant="outline"
            >
              {trans("sessions.sign_out_current")}
            </Button>
          </DialogClose>
          <Separator />
          <p>{trans("sessions.sign_out_elsewhere_description")}</p>
          <Button
            linkProps={{
              href: route("sessions.delete", {
                type: "others",
              }),
              method: "delete",
              preserveState: true,
            }}
            variant="outline"
          >
            {trans("sessions.sign_out_elsewhere")}
          </Button>
          <Separator />
          <p>{trans("sessions.sign_out_everywhere_description")}</p>
          <DialogClose asChild={true}>
            <Button
              linkProps={{
                href: route("sessions.delete", {
                  type: "all",
                }),
                method: "delete",
                preserveState: true,
              }}
              variant="outline"
            >
              {trans("sessions.sign_out_everywhere")}
            </Button>
          </DialogClose>
        </SectionContent>
      </SectionRoot>
    </>
  );
}

export default SecurityForm;
