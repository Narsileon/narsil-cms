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
        <SectionContent className="grid gap-4 text-sm">
          <p>{trans("sessions.sign_out_current_description")}</p>
          <DialogClose asChild={true}>
            <Button
              linkProps={{
                href: route("sessions.delete", {
                  type: "current",
                }),
                method: "delete",
              }}
              label={trans("sessions.sign_out_current")}
              variant="outline"
            />
          </DialogClose>
          <Separator />
          <p>{trans("sessions.sign_out_elsewhere_description")}</p>
          <Button
            label={trans("sessions.sign_out_elsewhere")}
            linkProps={{
              href: route("sessions.delete", {
                type: "others",
              }),
              method: "delete",
              preserveState: true,
            }}
            variant="outline"
          />
          <Separator />
          <p>{trans("sessions.sign_out_everywhere_description")}</p>
          <DialogClose asChild={true}>
            <Button
              label={trans("sessions.sign_out_everywhere")}
              linkProps={{
                href: route("sessions.delete", {
                  type: "all",
                }),
                method: "delete",
                preserveState: true,
              }}
              variant="outline"
            />
          </DialogClose>
        </SectionContent>
      </SectionRoot>
    </>
  );
}

export default SecurityForm;
