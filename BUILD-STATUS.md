# Build status - SIB 2026 final project

Updated 2026-11-10. This records what actually runs and what was verified, not
what is planned. The official calendar (20 Nov - 18 Dec 2026 work, 16-18 Dec
rehearsal, 21-23 Dec assessment) is unchanged.

## Environment

| Component | Value |
| --- | --- |
| OS | Windows 11 Pro |
| Host RAM | 7.8 GB (representative 8 GB laptop) |
| PowerShell | 5.1.26100 |
| Git for Windows | 2.56.0 (+ Git Bash 5.3.15) |
| PHP | 8.2.4 (XAMPP), `pdo_sqlite`, `curl`, `zip` |
| Python | not installed (Store alias only); not required |
| Docker | not installed; not required for the current build |

No Python-dependent bootstrap is needed. Spec Kit scripts can still run under
Git Bash; `scripts/select-feature.ps1` replaces the Python feature selector in
each lab repository.

## Repositories

| Repository | State |
| --- | --- |
| planning (this repo) | DFIR and GRC packages added |
| `vapt-labs/` | 3 of 3 targets implemented and packaged |
| `soc-labs/` | 3 of 3 cases implemented and packaged |
| `devsecops-labs/` | 2 of 2 cases implemented and packaged |

`.specify/feature.json` is set in each lab repository and is intentionally
gitignored machine-local state.

## Theme status

| Theme | Implementation | Key verification |
| --- | --- | --- |
| VAPT | KampusMart, PerpusDigital, EventPass; vulnerable + patched | 29/29, 24-25/25, 25/25 checks; packages verify with zero hash mismatches |
| DFIR | 3 static evidence packages + separate mentor keys | manifests 0 mismatches; 51/51 integrity checks; 36/36 Q1-Q12 coverage |
| SOC | 3 datasets + replay/query/evaluate/freeze/package harness | SOC-1 8/0/13/34 and 7/0/9/16; SOC-2 3/0/2/20 both; SOC-3 12/0/2/12 both |
| GRC/BCP | 2 tabletops with staged injects, templates, mentor ranges | manifests 0 mismatches; both answer keys parse; legal articles checked on official JDIH pages |
| DevSecOps | CampusAPI release gate; BuildGate provenance with RSA signatures | DEV-1 13/13 verifications; DEV-2 20/20 verifications |

Metric order is TP/FP/FN/TN.

## Hardening completed after the pilot

- SOC event notes neutralized; victim baselines added; sequence/label and flow-id
  inconsistencies fixed; rule format and engine limits documented.
- Sigma mapping note added: `soc-labs/docs/SIGMA-MAPPING.md`.
- DEV-2 uses a local RSA-2048 test key, detached signatures over canonicalized
  attestations, and a public-key fingerprint in the trust policy. Unsigned, bad
  signature, and untrusted-key fixtures are rejected.
- DFIR binary decision memo plus a verified PCAP/SQLite prototype:
  `dfir-cases/docs/DFIR-ARTIFACT-DECISION.md`.
- GRC legal recheck: PP 71/2019 confirmed in force; no Lembaga PDP establishment
  instrument found in the official search, still flagged:
  `grc-tabletops/docs/LEGAL-VERIFICATION-2026-11-10.md`.

## Measured VAPT footprint

- PHP process working set: 22.0 MB; private bytes 9.6 MB.
- Start to healthy: under 3 seconds.
- Package size: about 0.1 MB per target.
- Listen address: `127.0.0.1` only (verified with `Get-NetTCPConnection`).
- Reset restored seeded orders, coupons, markers, and an empty evidence log.
- Packaging prunes instructor tests and regenerates the manifest; all three
  packages verify with zero mismatches.

## Public / private separation

- Instructor keys live in `instructor-private/` and are gitignored:
  DFIR mentor keys, GRC answer ranges, SOC holdout labels and reference rules,
  DevSecOps golden artifacts and expected outcomes.
- Participant packages contain one case only. Automated release checks confirmed
  no holdout labels, reference rules, golden artifacts, expected outcomes, or
  e2e tests in the shipped zips.
- VAPT packages are grey-box because PHP ships as source; grading requires a
  reproducible request and evidence ID, not a marker value alone.

## Pilot and calibration

- An **agent-assisted blind dry pilot** was run: three VAPT targets and three SOC
  cases, each reviewer confined to its participant package. See
  `PILOT-2026-11-10.md`.
- VAPT: all 3 proofs found per target; 3.5-10.5 minutes; PerpusDigital hardest,
  EventPass easiest.
- SOC: final rules 10/0/11/28 (SOC-1), 4/0/1/19 (SOC-2), 12/0/2/12 (SOC-3);
  SOC-2 hardest.
- Defects found by the pilot (build-id check, evidence loss on reset, Q9
  discoverability, evidence oracle, missing staff UI, note leakage, wrong flow id)
  were fixed and re-tested.

## Remaining work (honest)

1. **Human blind pilot** on representative student laptops for all five themes.
   The agent dry pilot is not a substitute; it may overperform humans and VAPT is
   grey-box.
2. Remote/mentor-hosted fallback for devices that fail the local pilot.
3. DFIR mentor decision on the optional PCAP/SQLite add-on. A verified prototype
   and memo exist (`dfir-cases/docs/DFIR-ARTIFACT-DECISION.md`); EVTX has not
   been prototyped.
4. Lembaga PDP establishment still requires verification. PP 71/2019 is confirmed
   in force; no establishment instrument was found in an official search.
5. Blind review of student-facing cards and rubric scoring.
6. Push to GitHub after the maintainer confirms identity/remote. All commits are
   local.

## Verify locally

```powershell
# VAPT
cd vapt-labs
.\tools\lab.ps1 -Action build -Target kampusmart -Variant vulnerable
.\tools\lab.ps1 -Action test  -Target kampusmart -Variant vulnerable -Port 8081

# SOC
cd ..\soc-labs
.\tools\soc.ps1 -Action selfcheck -Case soc-1

# DevSecOps
cd ..\devsecops-labs\instructor-private\dev-1
.\verify.ps1

# DFIR
cd ..\..\dfir-cases
php tools\verify.php

# GRC manifests
cd ..\grc-tabletops\01-konseling
Get-Content manifest-sha256.txt
```

## Commit state

Lab repositories have local milestone commits per theme. This planning repository
has the DFIR and GRC packages. Nothing was pushed; no force push was used.
